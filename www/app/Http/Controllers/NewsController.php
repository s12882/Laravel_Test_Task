<?php

namespace App\Http\Controllers;

use App\Enums\NewsStatus;
use App\Http\Requests\NewsRequest;
use App\Services\NewsService;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Logic\FileHandler;
use Illuminate\Support\Facades\Log;

class NewsController extends Controller
{

    public function __construct(NewsService $newsService, UserService $userService)
    {
        $this->modelService = $newsService;
        $this->userService = $userService;
        $this->messageModel = trans('models.news');
        $this->filesFolder = '/images/news';
    }

    public function index()
    {
        return view('news.index', [
            'news' => $this->modelService->lists()]
            );
    }

    public function create()
    {
        return view('news.edit', [
            'pageTitle' => 'Create news',
            'news' => null,
            'postAction' => route('news.store'),
            'actionMethod' => 'POST',
        ]);
    }

    public function store(Request $request)
    {
        $news = $this->modelService->store($request);
        if ($news) {
            $images = $request->file('images');
            if (count($images) > 0) {
                foreach ($images as $image) {
                    try {
                        $fileHandler = new FileHandler($this->filesFolder);
                        $fileName = $fileHandler->setAndGetFilename($image);

                        if ($this->modelService->store_image($fileHandler->getFileInfoForNews($news->id))) {
                            $fileHandler->save();
                        }
                    } catch (\Exception $e) {
                        Log::warning($e->getMessage());
                    }
                }
            }
            return redirect()->route('news.index')->withSuccess(trans('actions.created_n', ['object' => $this->messageModel]));
        }
        return back()->withErrors(trans('actions.not_created_n', ['object' => $this->messageModel]));
    }

    public function show($id)
    {
        $news = $this->modelService->get($id);
        return view('news.show', [
            'news' => $news,
            'postAction' => route('comment.store'),
            'actionMethod' => 'POST',
            'deleteURL' => env('APP_URL') . '/comment/',
        ]);
    }

    public function download_image($id) {
        $image = $this->modelService->get_image($id);
        $headers = array(
          'Content-Type' => $image->type,
        );
        return response()->download($image->fullPath(), $image->original_file_name, $headers);
    }

    public function destroy_image($id) {
        $image = $this->modelService->get_image($id);

        try {
            $fileHandler = new FileHandler($this->filesFolder);
            if ($this->modelService->destroy_image($id)) {
                $fileHandler->deleteFile($image->webPath());
            } else {
                return back()->withErros(trans('actions.image_not_deleted'));
            }
        } catch (\Exception $e) {
            Log::warning($e->getMessage());
            return back()->withErrors($e->getMessage());
        }

        return back()->with('success', trans('actions.image_deleted'));
    }

    public function edit($id)
    {
        $news = $this->modelService->get($id);
        $postAction = route('news.update', ['news' => $news->id]);
        $actionMethod = 'PATCH';
        return view('news.edit', [
            'news' => $news,
            'postAction' => $postAction,
            'actionMethod' => $actionMethod,
            'pageTitle' => 'Edit ' . $news->name,
        ]);
    }

    public function update(NewsRequest $request)
    {
        $news = $this->modelService->update($request);
        if ($news) {
            $images = $request->file('images');
            if (count($images) > 0) {
                foreach ($images as $image) {
                    try {
                        $fileHandler = new FileHandler($this->filesFolder);
                        $fileName = $fileHandler->setAndGetFilename($image);
                        if ($this->modelService->store_image($fileHandler->getFileInfoForNews($request->get('id')))) {
                            $fileHandler->save();
                        }
                    } catch (\Exception $e) {
                        Log::warning($e->getMessage());
                    }
                }
            }
           
            return redirect()->route('news.index')->withSuccess(trans('actions.updated_n', ['object' => $this->messageModel]));
        }
        return back()->withErrors(trans('actions.not_updated_n', ['object' => $this->messageModel]));
    }

    public function destroy($id)
    {
        $news = $this->modelService->get($id);
        $images = $news->images;
        if (count($images) > 0) {
            foreach ($images as $image) {
                try {
                    $fileHandler = new FileHandler($this->filesFolder);
                    $fileHandler->deleteFile($this->filesFolder.'/'.$image->file_name);
                } catch (\Exception $e) {
                    Log::warning($e->getMessage());
                }
            }
        }

        if($this->modelService->destroy($id)){
            return redirect()->route('news.index')->withSuccess(trans('actions.deleted_n', ['object' => $this->messageModel]));
        }       
        return back()->withErrors(trans('actions.not_deleted_n', ['object' => $this->messageModel]));
    }


    public function datatables(Request $request)
    {
        return $this->modelService->datatables($request);
    }
}
