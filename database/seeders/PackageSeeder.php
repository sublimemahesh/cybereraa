<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('packages')->insert([
            ['name' => 'Basic 01', 'slug' => 'package-01', 'amount' => 100, 'month_of_period' => 30, 'daily_leverage' => 1],
            ['name' => 'Basic 02', 'slug' => 'package-02', 'amount' => 250, 'month_of_period' => 30, 'daily_leverage' => 1],
            ['name' => 'Basic 03', 'slug' => 'package-03', 'amount' => 500, 'month_of_period' => 30, 'daily_leverage' => 1],
            ['name' => 'Basic 04', 'slug' => 'package-04', 'amount' => 1000, 'month_of_period' => 30, 'daily_leverage' => 1],
            ['name' => 'Standard 01', 'slug' => 'standard-01', 'amount' => 2500, 'month_of_period' => 30, 'daily_leverage' => 1],
            ['name' => 'Standard 02', 'slug' => 'standard-02', 'amount' => 5000, 'month_of_period' => 30, 'daily_leverage' => 1],
            ['name' => 'Standard 03', 'slug' => 'standard-03', 'amount' => 10000, 'month_of_period' => 30, 'daily_leverage' => 1],
            ['name' => 'Standard 04', 'slug' => 'standard-04', 'amount' => 25000, 'month_of_period' => 30, 'daily_leverage' => 1],
            ['name' => 'VIP 01', 'slug' => 'vip-01', 'amount' => 50000, 'month_of_period' => 30, 'daily_leverage' => 1],
            ['name' => 'VIP 02', 'slug' => 'vip-02', 'amount' => 100000, 'month_of_period' => 30, 'daily_leverage' => 1],
            ['name' => 'VIP 03', 'slug' => 'vip-03', 'amount' => 250000, 'month_of_period' => 30, 'daily_leverage' => 1],
            ['name' => 'VIP 04', 'slug' => 'vip-04', 'amount' => 500000, 'month_of_period' => 30, 'daily_leverage' => 1],
        ]);
    }
}
