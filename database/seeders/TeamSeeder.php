<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('teams')->insert(
            [
                //Super Admin
                [
                    'user_id' => '1',
                    'name' => "Super Admin's Team",
                    'personal_team' => 1,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                //Admin
                [
                    'user_id' => '2',
                    'name' => 'Admin\'s Team',
                    'personal_team' => 1,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                //User
                [
                    'user_id' => '3',
                    'name' => 'Allex\'s Team',
                    'personal_team' => 1,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                //User
                [
                    'user_id' => '4',
                    'name' => 'Anna\'s Team',
                    'personal_team' => 1,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                //User
                [
                    'user_id' => '5',
                    'name' => 'Debra\'s Team',
                    'personal_team' => 1,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                //User
                [
                    'user_id' => '6',
                    'name' => 'Tycoon1m\'s Team',
                    'personal_team' => 1,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
            ]
        );
    }
}
