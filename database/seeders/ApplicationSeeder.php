<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('applications')->insert(   [
            'code' => random_code(),
            'first_name' => fake()->firstName(),
            'middle_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'mobile' => clean(mt_rand(1000000000, 9999999999)),
            'status' => 'pending',
            'token' => md5(fake()->unique()->safeEmail() . time()),
            'agent_id' => 4,
            'created_at' => date('Y-m-d H:i:s')
        ],);
    }
}
