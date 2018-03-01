<?php

namespace App\Services;

use App\Enums\DtButtonType;
use App\Helpers\DtButtonHelper;
use App\Models\Response;
use Auth;
use Yajra\Datatables\Datatables;

class ResponseService
{
    public function get($id)
    {
        return $this->resp()->where('id', $id)->first();
    }

    public function resp()
    {
        $baseQuery = Response::select();
        $resp = $baseQuery;
        return $resp;
    }

    public function lists()
    {
        return Response::orderBy('name')->select('name', 'id')->pluck('name', 'id');
    }

    public function store($input)
    {
     
        try{
            \DB::beginTransaction();
            $resp = Response::create($input->except('_token'));
            $resp->save();
            \DB::commit();
            return $resp;
        }catch(\PDOException $e){
            \DB::rollBack();
            return false;
        }
    }

    public function update($input)
    {    
        try {
            \DB::beginTransaction();
            $resp = Response::findOrFail($input['id']);
            $input['finished_at'] = date('Y-m-d H:m:s');
            $resp->update($input->except(['id']));
            \DB::commit();
            return true;
        } catch (\PDOException $e) {
            \DB::rollBack();
            return false;
        }
    }

    public function destroy($id)
    {
        return Response::findOrFail($id)->delete();
    }

    public function restore($id)
    {
        return Response::withTrashed()->findOrFail($id)->restore();
    }

    public function datatables($input)
    {
        $query = $this->resp();
        $datatables = Datatables::of($query)
            ->addColumn('actions', function ($resp) {
                $actions = '';
                 $actions .= DtButtonHelper::getByType(route('resp.show', ['resp' => $resp->id]), DtButtonType::SHOW);
                if(Auth::user()->hasPermissionTo('update resp'))
                    $actions .= DtButtonHelper::getByType(route('resp.edit', ['resp' => $resp->id]), DtButtonType::EDIT);                   
                if (Auth::user()->hasPermissionTo('delete resp')) {
                    $actions .= DtButtonHelper::getByType(route('resp.destroy', ['resp' => $resp->id]), DtButtonType::DELETE);
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
