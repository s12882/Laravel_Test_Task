<?php

namespace App\Services;

use App\Enums\DtButtonType;
use App\Helpers\DtButtonHelper;
use App\Models\News;
use App\Models\NewsImage;
use Auth;
use Yajra\Datatables\Datatables;

class NewsService
{
    public function get($id)
    {
        return $this->news()->where('id', $id)->first();
    }

    public function news()
    {
        $baseQuery = News::select();
        $news = $baseQuery;
        return $news;
    }

    public function lists()
    {
        return News::orderBy('name')->select('name', 'id')->pluck('name', 'id');
    }

    public function store($input)
    {
     
        try{
            \DB::beginTransaction();
            $news = News::create($input->except('_token'));
            $news->save();
            \DB::commit();
            return $news;
        }catch(\PDOException $e){
            \DB::rollBack();
            return false;
        }
    }


    public function update($input)
    {    
        try {
            \DB::beginTransaction();
            $news = News::findOrFail($input['id']);
            $input['finished_at'] = date('Y-m-d H:m:s');
            $news->update($input->except(['id']));
            \DB::commit();
            return true;
        } catch (\PDOException $e) {
            \DB::rollBack();
            return false;
        }
    }

    public function get_image($id) {
        return NewsImage::findOrFail($id);
    }

    public function store_image($input) {
        return NewsImage::create($input);
    }

    public function destroy_image($id) {
        return NewsImage::findOrFail($id)->delete();
    }

    public function destroy($id)
    {
        return News::findOrFail($id)->delete();
    }

    public function restore($id)
    {
        return News::withTrashed()->findOrFail($id)->restore();
    }

    public function datatables($input)
    {
        $query = $this->news();
        $datatables = Datatables::of($query)
            ->addColumn('actions', function ($news) {
                $actions = '';
                 $actions .= DtButtonHelper::getByType(route('news.show', ['news' => $news->id]), DtButtonType::SHOW);
                if(Auth::user()->hasPermissionTo('update news'))
                    $actions .= DtButtonHelper::getByType(route('news.edit', ['news' => $news->id]), DtButtonType::EDIT);                   
                if (Auth::user()->hasPermissionTo('delete news')) {
                    $actions .= DtButtonHelper::getByType(route('news.destroy', ['news' => $news->id]), DtButtonType::DELETE);
                }
                return $actions;
            });

        if ($input['date_from']) 
            $datatables->where('created_at', '>=', $input['date_from'].' 23:59:59');
        
        if ($input['date_to']) 
            $datatables->where('created_at', '<=', $input['date_to'].' 23:59:59');

        return $datatables->rawColumns(['actions'])->make(true);
    }

}
