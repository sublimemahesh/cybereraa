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
        DB::table('strategies')->upsert([
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
                'name' => 'minimum_p2p_transfer_limit',
                'data_type' => 'double',
                'value' => 5,
                'comment' => 'Minimum amount needed for transfer p2p',
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
                'value' => '{"package": 300, "commission": 100}',
                'comment' => 'In percentage',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'level_commission_requirement',
                'data_type' => 'int',
                'value' => 5,
                'comment' => 'How many direct sales are required to unlock level commissions',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'commission_level_count',
                'data_type' => 'int',
                'value' => 4,
                'comment' => 'How many levels are allowed to give commission',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'commissions',
                'data_type' => 'json',
                'value' => '{"1":"5","2":"2.5","3":"1.5","4":"1"}',
                'comment' => 'Commission percentages for each commission allowed levels',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'trade_income',
                'data_type' => 'json',
                'value' => '{"1":"50","2":"25","3":"12.50","4":"6.25"}',
                'comment' => 'Trade Income percentages for each level',
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
                'value' => '{"3":{"active_investment":"1000","total_team_investment":"5000"},"4":{"active_investment":"2500","total_team_investment":"10000"},"5":{"active_investment":"5000","total_team_investment":"25000"},"6":{"active_investment":"10000","total_team_investment":"50000"},"7":{"active_investment":"25000","total_team_investment":"100000"}}',
                'comment' => 'Minimum package values required for corresponding rank',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'special_bonus_requirement',
                'data_type' => 'json',
                'value' => '{"1":{"direct_sales":"2","total_investment":"1000","bonus":"2"},"2":{"direct_sales":"20","total_investment":"10000","bonus":"2"},"3":{"direct_sales":"30","total_investment":"15000","bonus":"2"}}',
                'comment' => 'Special Bonus requirements must user need to get for eligible for direct sale special bonus',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'rank_bonus',
                'data_type' => 'int',
                'value' => 0,
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
                'value' => 0,
                'comment' => 'Rank gift percentage for selected rank level users',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'rank_gift_levels',
                'data_type' => 'array',
                'value' => '1,2,3,4,5,6,7',
                'comment' => 'Rank gifts selected levels',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'payable_percentages',
                'data_type' => 'json',
                'value' => '{"direct":"100","indirect":"100","package":"1","rank_bonus":"100"}',
                'comment' => 'Direct , Indirect & Rank bonus daily payable percentage',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'rank_gift_requirements',
                'data_type' => 'json',
                'value' => '{"1":{"total_investment":"250","total_team_investment":"2000"},"2":{"total_investment":"500","total_team_investment":"12000"},"3":{"total_investment":"1000","total_team_investment":"75000"},"4":{"total_investment":"2500","total_team_investment":"400000"},"5":{"total_investment":"5000","total_team_investment":"2500000"},"6":{"total_investment":"10000","total_team_investment":"15000000"},"7":{"total_investment":"25000","total_team_investment":"100000000"}}',
                'comment' => 'Rank gift requirements must user need to get for eligible for get rank gift.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'p2p_restricted_users',
                'data_type' => 'json',
                'value' => '[3]',
                'comment' => 'P2P restricted user ids',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'staking_withdrawal_fee',
                'data_type' => 'double',
                'value' => 10,
                'comment' => 'Transaction fee for withdrawal from staking wallet',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'min_custom_investment',
                'data_type' => 'double',
                'value' => 10,
                'comment' => 'Minimum Custom Investment Amount',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'max_custom_investment',
                'data_type' => 'double',
                'value' => 5000,
                'comment' => 'Maximum Custom Investment Amount',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'custom_investment_gas_fee',
                'data_type' => 'double',
                'value' => 2,
                'comment' => 'Custom Investment Gas Fee In percentage',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'investment_start_at',
                'data_type' => 'int',
                'value' => 2,
                'comment' => 'How many days after the daily earnings start from the package purchase date',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ], 'name');
    }
}
