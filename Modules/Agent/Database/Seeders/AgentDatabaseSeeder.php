<?php

namespace Modules\Agent\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class AgentDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $seeds = [
            [
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
            ],
           
        ];
        foreach ($seeds as $seed) {
            DB::table('license_agents')->insert($seed);
        }

        // $this->call("OthersTableSeeder");
    }
}
