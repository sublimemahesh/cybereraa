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
                'name' => 'payout_transfer_fee',
                'data_type' => 'double',
                'value' => 5,
                'comment' => 'Transaction fee for payout to binance wallet',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'p2p_transfer_fee',
                'data_type' => 'double',
                'value' => 2.5,
                'comment' => 'Transaction fee for peer to peer transaction',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'minimum_payout_limit',
                'data_type' => 'double',
                'value' => 10,
                'comment' => 'Minimum amount needed for request payout',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'max_withdraw_limit',
                'data_type' => 'int',
                'value' => 400,
                'comment' => 'In percentage',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'withdrawal_limits',
                'data_type' => 'json',
                'value' => '{"package:" 300, "commission": 100}',
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
                'data_type' => 'json',
                'value' => '{"1":25,"2":20,"3":15,"4":10,"5":5,"6":5,"7":5}',
                'comment' => 'Commission percentages for each commission allowed levels',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'rank_level_count',
                'data_type' => 'int',
                'value' => 7,
                'comment' => 'How many levels are allowed to give ranks for users',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'rank_package_requirement',
                'data_type' => 'json',
                'value' => '{"1":100,"2":250,"3":500,"4":1000,"5":2500,"6":5000,"7":10000}',
                'comment' => 'Minimum package values required for corresponding rank',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'rank_bonus',
                'data_type' => 'int',
                'value' => '10',
                'comment' => 'Rank bonus percentage for selected rank level users',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'rank_bonus_levels',
                'data_type' => 'array',
                'value' => '3,4,5,6,7',
                'comment' => 'Rank bonus selected levels',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'rank_gift',
                'data_type' => 'int',
                'value' => '5',
                'comment' => 'Rank gift percentage for selected rank level users',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'rank_gift_levels',
                'data_type' => 'array',
                'value' => '1,2',
                'comment' => 'Rank gifts selected levels',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'payable_percentages',
                'data_type' => 'json',
                'value' => '{"direct":0.332,"indirect":0.332,"rank_bonus":0.332}',
                'comment' => 'Direct , Indirect & Rank bonus daily payable percentage',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
