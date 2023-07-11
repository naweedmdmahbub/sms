<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['name' => 'view menu element ui', 'guard_name' => 'api', 'permission_prefix_id' => '1'],
            ['name' =>  'view menu permission', 'guard_name' => 'api', 'permission_prefix_id' => '1'],
            ['name' =>  'view menu components', 'guard_name' => 'api', 'permission_prefix_id' => '1'],
            ['name' =>  'view menu charts', 'guard_name' => 'api', 'permission_prefix_id' => '1'],
            ['name' =>  'view menu nested routes', 'guard_name' => 'api', 'permission_prefix_id' => '1'],
            ['name' =>  'view menu table', 'guard_name' => 'api', 'permission_prefix_id' => '1'],
            ['name' =>  'view menu administrator', 'guard_name' => 'api', 'permission_prefix_id' => '1'],
            ['name' =>  'view menu theme', 'guard_name' => 'api', 'permission_prefix_id' => '1'],
            ['name' =>  'view menu clipboard', 'guard_name' => 'api', 'permission_prefix_id' => '1'],
            ['name' =>  'view menu excel', 'guard_name' => 'api', 'permission_prefix_id' => '1'],
            ['name' =>  'view menu zip', 'guard_name' => 'api', 'permission_prefix_id' => '1'],
            ['name' =>  'view menu pdf', 'guard_name' => 'api', 'permission_prefix_id' => '1'],
            ['name' =>  'view menu i18n', 'guard_name' => 'api', 'permission_prefix_id' => '1'],
            ['name' =>  'manage article', 'guard_name' => 'api', 'permission_prefix_id' => '1'],
            ['name' =>  'manage permission', 'guard_name' => 'api', 'permission_prefix_id' => '2'],
            //users permission
            ['name' =>  'manage user', 'guard_name' => 'api', 'permission_prefix_id' => '3'],
            ['name' =>  'view user list', 'guard_name' => 'api', 'permission_prefix_id' => '3'],
            ['name' =>  'add user', 'guard_name' => 'api', 'permission_prefix_id' => '3'],
            ['name' =>  'update user', 'guard_name' => 'api', 'permission_prefix_id' => '3'],
            ['name' =>  'view user', 'guard_name' => 'api', 'permission_prefix_id' => '3'],
            // students permissions
            ['name' =>  'manage student', 'guard_name' => 'api', 'permission_prefix_id' => '6'],
            ['name' =>  'view student list', 'guard_name' => 'api', 'permission_prefix_id' => '6'],
            ['name' =>  'add student', 'guard_name' => 'api', 'permission_prefix_id' => '6'],
            ['name' =>  'update student', 'guard_name' => 'api', 'permission_prefix_id' => '6'],
            ['name' =>  'view student', 'guard_name' => 'api', 'permission_prefix_id' => '6'],
            // departments permissions
            ['name' =>  'manage department', 'guard_name' => 'api', 'permission_prefix_id' => '7'],
            ['name' =>  'view department list', 'guard_name' => 'api', 'permission_prefix_id' => '7'],
            ['name' =>  'add department', 'guard_name' => 'api', 'permission_prefix_id' => '7'],
            ['name' =>  'update department', 'guard_name' => 'api', 'permission_prefix_id' => '7'],
            ['name' =>  'view department', 'guard_name' => 'api', 'permission_prefix_id' => '7'],
        ];

        DB::table('permissions')->insert($permissions);
    }
}
