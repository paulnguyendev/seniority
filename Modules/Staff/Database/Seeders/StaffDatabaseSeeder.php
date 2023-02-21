<?php
namespace Modules\Staff\Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class StaffDatabaseSeeder extends Seeder
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
                'first_name' => 'Super',
                'middle_name' => '',
                'last_name' => 'Admin',
                'email' => 'super.admin@yahoo.com',
                'username' => 'superadmin',
                'status' => 'active',
                'password' => md5(123456),
                'token' => md5('super.admin@yahoo.com' . time()),
            ],
        ];
        foreach ($seeds as $seed) {
            DB::table('staffs')->insert($seed);
        }
        // $this->call("OthersTableSeeder");
    }
}
