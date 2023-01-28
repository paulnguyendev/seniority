<?php
namespace Modules\MLM\Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class MLMSettingDatabaseSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        // $seeds = [
        //     // Direct
        //     [
        //         'name' => 'Mortgage Ambassador',
        //         'key' => 'MA',
        //         'commission' => 50,
        //         'commission_type' => 'percentage',
        //         'commission_group' => 'direct',
        //         'mlm_level_id' => 1,
        //     ],
        //     [
        //         'name' => 'Senior MA',
        //         'key' => 'SMA',
        //         'commission' => 55,
        //         'commission_type' => 'percentage',
        //         'commission_group' => 'direct',
        //         'mlm_level_id' => 1,
        //     ],
        // ];
        // foreach ($seeds as $seed) {
        //     DB::table('mlm_settings')->insert($seed);
        // }
        // $this->call("OthersTableSeeder");
    }
}
