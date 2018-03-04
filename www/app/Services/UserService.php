<?php

namespace App\Services;

use App\Models\User;
use Yajra\Datatables\Datatables;
use App\Helpers\DtButtonHelper;
use App\Enums\DtButtonType;
use Auth;
use Mail;
use Spatie\Permission\Models\Role;
use App\Mail\NewAccount;

class UserService {

    public function get($id) {
        return $this->users()->where('id', $id);
    }

    public function users()
    {
        $baseQuery = User::select();
        $users = $baseQuery;
        return $users;
    }
    public function lists() {
        return User::orderBy('first_name')->select(\DB::raw('CONCAT(first_name," ",surname) as fullName'),'id')->pluck('fullName','id');
    }

    public function store($input) {
      
      if($input['generatePassword'] == 1)
        $pass = str_random(8);
      else
        $pass = $input['password'];

      $input['password'] = \Hash::make($pass);

      $user = User::create($input->except('_token'));
      
      if(Auth::user()->hasPermissionTo('change role'))
        $user->assignRole(Role::findOrFail($input['role_id']));

      // if($user)
      //    Mail::to($input['email'])->send(new NewAccount($user, $pass));
      return $user;
    }

    public function update($input)
    {
      $user = User::findOrFail($input['id']);
      $exceptInUpdate = ['id', '_token'];

      if(Auth::user()->hasPermissionTo('change role'))
        $user->syncRoles([Role::findOrFail($input['role_id'])]);

      if(!isset($input['password']) || empty($input['password']))
        array_push($exceptInUpdate, 'password');
      else
        $input['password'] = \Hash::make($input['password']);
      
      return User::findOrFail($input['id'])->update($input->except($exceptInUpdate));
    }

    public function destroy($id) {
        if(Auth::id() != $id)
        return User::findOrFail($id)->delete();
    }

    public function activate($id) {
        $user = User::findOrFail($id);
        $user->is_active = 1;
        return $user->save();
    }

    public function deactivate($id) {
        $current_user = Auth::user();
        $user = User::findOrFail($id);
        if($current_user->id != $user->id){
          $user->is_active = 0;
          return $user->save();
        }
        return FALSE;
    }

    public function datatables($input) {
      $query = $this->users();
      $datatables = Datatables::of($query);

      if(Auth::user()->hasAnyPermission(['update user','acivate/deactivate users','delete user'])){
        $datatables = $datatables->addColumn('actions', function($user) {
        $permissions = Auth::user()->getAllPermissions()->pluck('name', 'id')->toArray();
          $actions = '';
          if(in_array('update user', $permissions))
            $actions .= DtButtonHelper::getByType(route('user.edit', ['User' => $user->id]), DtButtonType::EDIT);
          if(in_array('acivate/deactivate users', $permissions)){
            if($user->is_active == 0)
              $actions .= DtButtonHelper::getByType(route('user.activate', ['user' => $user->id]), DtButtonType::ACTIVATE);
            elseif($user->is_active == 1 && $user->id != Auth::user()->id)
              $actions .= DtButtonHelper::getByType(route('user.deactivate', ['user' => $user->id]), DtButtonType::DEACTIVATE);
            }
          if(in_array('delete user', $permissions) && Auth::id() != $user->id)
            $actions .= DtButtonHelper::getByType(route('user.destroy', ['user' => $user->id]), DtButtonType::DELETE);
          return $actions;
          });
        }
        return $datatables->rawColumns(['actions'])->make(true);
    }

}
