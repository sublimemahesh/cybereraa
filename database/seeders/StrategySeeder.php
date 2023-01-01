<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class StrategySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('strategies')->insert([
            [
                'name' => 'max_withdraw_limit',
                'data_type' => 'int',
                'value' => 400,
                'comment' => 'In percentage',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'commission_level_count',
                'data_type' => 'int',
                'value' => 7,
                'comment' => 'How many levels are allowed to give commission',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'commissions',
                'data_type' => 'array',
                'value' => '{"1":25,"2":20,"3":15,"4":10,"5":5,"6":5,"7":5}',
                'comment' => 'Commission percentages for each commission allowed levels',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'rank_package_requirement',
                'data_type' => 'array',
                'value' => '{"1":100,"2":250,"3":500,"4":1000,"5":2500,"6":5000,"7":10000}',
                'comment' => 'Minimum package values required for corresponding rank',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
