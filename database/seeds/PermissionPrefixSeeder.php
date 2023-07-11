<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionPrefixSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission_prefixes = [
            ['name' => 'administrator'],
            ['name' => 'permission'],
            ['name' => 'user'],
            ['name' => 'student'],
            ['name' => 'department'],
        ];

        DB::table('permission_prefixes')->insert($permission_prefixes);
    }
}
