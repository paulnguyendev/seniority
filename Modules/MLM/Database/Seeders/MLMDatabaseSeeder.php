<?php
namespace Modules\MLM\Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class MLMDatabaseSeeder extends Seeder
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
                'name' => 'Licensed',
                'class' => 'badge-soft-primary',
                'slug' => 'licensed'
            ],
            [
                'name' => 'Non-Licensed',
                'class' => 'badge-soft-warning',
                'slug' => 'non-licensed'
            ],
        ];
        foreach ($seeds as $seed) {
            DB::table('mlm_types')->insert($seed);
        }
        $seeds = [
            // Licenced -> id = 1
            [
                'id' => 1,
                'name' => 'Mortgage Ambassador',
                'short_name' => 'MA',
                'number_order' => 0,
                'number_child' => 0,
                'mlm_type_id' => 1,
            ],
            [
                'id' => 2,
                'name' => 'MSenior MA',
                'short_name' => 'SMA',
                'number_order' => 3,
                'number_child' => 1,
                'child_id' => 1,
                'mlm_type_id' => 1,
            ],
            [
                'id' => 3,
                'name' => 'Elite MA',
                'short_name' => 'EMA',
                'number_order' => 5,
                'number_child' => 1,
                'child_id' => 2,
                'mlm_type_id' => 1,
            ],
            [
                'id' => 4,
                'name' => 'Grand MA',
                'short_name' => 'GMA',
                'number_order' => 7,
                'number_child' => 1,
                'child_id' => 3,
                'mlm_type_id' => 1,
            ],
            [
                'id' => 5,
                'name' => 'District Leader',
                'short_name' => 'RMB',
                'number_child' => 1,
                'child_id' => 4,
                'mlm_type_id' => 1,
            ],
            [
                'id' => 6,
                'name' => 'Regional Leader',
                'short_name' => 'EBM',
                'number_child' => 1,
                'child_id' => 5,
                'mlm_type_id' => 1,
            ],
            [
                'id' => 7,
                'name' => 'National Branch Leader ',
                'short_name' => 'NBL',
                'number_child' => 1,
                'child_id' => 6,
                'mlm_type_id' => 1,
            ],
            // Licenced -> id = 2
            [
                'id' => 8,
                'name' => 'Community Ambassador',
                'short_name' => 'CA',
                'number_lead' => 0,
                'number_child' => 0,
                'mlm_type_id' => 2,
            ],
            [
                'id' => 9,
                'name' => 'Senior CA ',
                'short_name' => 'SCA',
                'number_lead' => 3,
                'number_child' => 1,
                'child_id' => 8,
                'mlm_type_id' => 2,
            ],
            [
                'id' => 10,
                'name' => 'Elite CA ',
                'short_name' => 'ECA',
                'number_lead' => 5,
                'number_child' => 1,
                'child_id' => 9,
                'mlm_type_id' => 2,
            ],
            [
                'id' => 11,
                'name' => 'Grand CA ',
                'short_name' => 'GCA',
                'number_lead' => 7,
                'number_child' => 1,
                'child_id' => 10,
                'mlm_type_id' => 2,
            ],
            [
                'id' => 12,
                'name' => 'District Leader',
                'short_name' => 'RBM',
             
                'number_child' => 1,
                'child_id' => 11,
                'mlm_type_id' => 2,
            ],
            [
                'id' => 13,
                'name' => 'Regional Leader',
                'short_name' => 'EMB',
                'number_child' => 1,
                'child_id' => 12,
                'mlm_type_id' => 2,
            ],
            [
                'id' => 14,
                'name' => 'National Leader',
                'short_name' => 'NL',
                'number_child' => 1,
                'child_id' => 13,
                'mlm_type_id' => 2,
            ],
        ];
        foreach ($seeds as $seed) {
            $seed['created_at'] = date('Y-m-d H:i:s');
            DB::table('mlm_levels')->insert($seed);
        }
        // $this->call("OthersTableSeeder");
    }
}
