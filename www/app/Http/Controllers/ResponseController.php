<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsRequest;
use App\Services\ResponseService;
use App\Models\User;
use Auth;
use App\Models\Response;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Logic\FileHandler;
use Illuminate\Support\Facades\Log;

class ResponseController extends Controller
{

    public function __construct(ResponseService $responseService, UserService $userService)
    {
        $this->modelService = $responseService;
        $this->userService = $userService;
        $this->messageModel = trans('models.resp');
        $this->filesFolder = '/images/resp';
        $this->middleware('auth');
    }

    public function index()
    {
        return view('resp.index', [
            'resp' => $this->modelService->lists()]
            );
    }

    public function create()
    {
       
        return view('resp.edit', [
            'pageTitle' => 'Create response',
            'resp' => null,
            'postAction' => route('resp.store'),
            'actionMethod' => 'POST',
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $request['email'] = $user->email;

        $resp = $this->modelService->store($request);
        if ($resp) {      
            return redirect()->route('resp.index')->withSuccess(trans('actions.created_n', ['object' => $this->messageModel]));
        }
        return back()->withErrors(trans('actions.not_created_n', ['object' => $this->messageModel]));
    }

    public function show($id)
    {
        $resp = $this->modelService->get($id);
        return view('resp.show', [
            'resp' => $resp,
            'postAction' => route('comment.store'),
            'actionMethod' => 'POST',
            'deleteURL' => env('APP_URL') . '/comment/',
        ]);
    }

    public function edit($id)
    {
        $resp = $this->modelService->get($id);
        $postAction = route('resp.update', ['resp' => $resp->id]);
        $actionMethod = 'PATCH';
        return view('resp.edit', [
            'resp' => $resp,
            'postAction' => $postAction,
            'actionMethod' => $actionMethod,
            'pageTitle' => 'Edit ' . $resp->name,
        ]);
    }

    public function update(ResponseRequest $request)
    {
        $resp = $this->modelService->update($request);
        if ($resp) {
            
            return redirect()->route('resp.index')->withSuccess(trans('actions.updated_n', ['object' => $this->messageModel]));
        }
        return back()->withErrors(trans('actions.not_updated_n', ['object' => $this->messageModel]));
    }

    public function destroy($id)
    {
        $resp = $this->modelService->get($id);
       
        if($this->modelService->destroy($id)){
            return redirect()->route('resp.index')->withSuccess(trans('actions.deleted_n', ['object' => $this->messageModel]));
        }       
        return back()->withErrors(trans('actions.not_deleted_n', ['object' => $this->messageModel]));
    }

    public function datatables(Request $request)
    {
        return $this->modelService->datatables($request);
    }
}
