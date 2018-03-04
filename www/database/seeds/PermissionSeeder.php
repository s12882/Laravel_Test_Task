<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use App\Models\User;
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()['cache']->forget('spatie.permission.cache');
        Permission::create(['name' => 'create user']);
        Permission::create(['name' => 'update user']);
        Permission::create(['name' => 'delete user']);
        Permission::create(['name' => 'list users']);

        Permission::create(['name' => 'create role']);
        Permission::create(['name' => 'update role']);
        Permission::create(['name' => 'delete role']);
        Permission::create(['name' => 'list roles']);

        Permission::create(['name' => 'create news']);
        Permission::create(['name' => 'update news']);
        Permission::create(['name' => 'delete news']);
        Permission::create(['name' => 'delete comment']);
		
		Permission::create(['name' => 'create response']);
        Permission::create(['name' => 'update response']);
        Permission::create(['name' => 'delete response']);

        Permission::create(['name' => 'change role']);

    }
}
