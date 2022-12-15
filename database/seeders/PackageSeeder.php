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
            ['name' => 'Package 01', 'slug' => 'package-01', 'amount' => 100, 'month_of_period' => 15, 'daily_leverage' => 1],
            ['name' => 'Package 02', 'slug' => 'package-02', 'amount' => 250, 'month_of_period' => 15, 'daily_leverage' => 1],
            ['name' => 'Package 03', 'slug' => 'package-03', 'amount' => 500, 'month_of_period' => 15, 'daily_leverage' => 1],
            ['name' => 'Package 04', 'slug' => 'package-04', 'amount' => 1000, 'month_of_period' => 15, 'daily_leverage' => 1],
            ['name' => 'Package 05', 'slug' => 'package-05', 'amount' => 2500, 'month_of_period' => 15, 'daily_leverage' => 1],
            ['name' => 'Package 06', 'slug' => 'package-06', 'amount' => 5000, 'month_of_period' => 15, 'daily_leverage' => 1],
            ['name' => 'Package 07', 'slug' => 'package-07', 'amount' => 10000, 'month_of_period' => 15, 'daily_leverage' => 1],
            ['name' => 'Package 08', 'slug' => 'package-08', 'amount' => 25000, 'month_of_period' => 15, 'daily_leverage' => 1],
            ['name' => 'Package 09', 'slug' => 'package-09', 'amount' => 50000, 'month_of_period' => 15, 'daily_leverage' => 1],
            ['name' => 'Package 10', 'slug' => 'package-10', 'amount' => 100000, 'month_of_period' => 15, 'daily_leverage' => 1],
        ]);
    }
}
