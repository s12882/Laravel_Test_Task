<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      app()['cache']->forget('spatie.permission.cache');
      $role = Role::create(['name' => 'Admin']);
      $role->givePermissionTo(Permission::all());

      $role1 = Role::create(['name' => 'User']);
      $role1->givePermissionTo('create response');
	  $role1->givePermissionTo('update user');
	  
	  $role2 = Role::create(['name' => 'Guest']);
	  $role2->givePermissionTo('create user');
    }
}
