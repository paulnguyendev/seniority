<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LicenseAgent extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('license_agents')->insert(   [
            'code' => 'SM999999',
            'first_name' => 'Root',
            'middle_name' => 'Seniority',
            'last_name' => 'System',
            'email' => 'root.seniority@yahoo.com',
            'username' => 'root',
            'status' => 'active',
            'password' => md5(123456),
            'token' => md5('root.seniority@yahoo.com' . time()),
            '_lft' => '1',
            '_rgt' => '2',
        ],);
    }
}
