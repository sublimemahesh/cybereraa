<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                //Super Admin
                [
                    'super_parent_id' => null,
                    'name' => 'Navod Hansajith',
                    'username' => 'super_admin',
                    'email' => 'hansajith.synotec@gmail.com',
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                ],
                //Admin
                [
                    'super_parent_id' => null,
                    'name' => 'James caron',
                    'username' => 'admin',
                    'email' => 'hansajithsynotec@gmail.com',
                    'email_verified_at' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                ],
                //User
                [
                    'super_parent_id' => null,
                    'name' => 'Coin1m 1st Level',
                    'username' => 'coin1m1',
                    'email' => 'noreply@coin1m.com',
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                ],
                //User
                [
                    'super_parent_id' => 3,
                    'name' => 'Coin1m 2nd Level',
                    'username' => 'coin1m2',
                    'email' => 'noreply@coin1m.com',
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                ],
                //User
                [
                    'super_parent_id' => 4,
                    'name' => 'Coin1m 3rd Level',
                    'username' => 'coin1m3',
                    'email' => 'noreply@coin1m.com',
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                ],
                //User
                [
                    'super_parent_id' => 5,
                    'name' => 'Coin1m 4th Level',
                    'username' => 'coin1m4',
                    'email' => 'noreply@coin1m.com',
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                ],
            ]
        );
        DB::table('profiles')->insert(
            [
                //Super Admin
                [
                    'user_id' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                //Admin
                [
                    'user_id' => 2,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                //User
                [
                    'user_id' => 3,
                    'created_at' => now(),
                    'updated_at' => now(),
                ], //User
                [
                    'user_id' => 4,
                    'created_at' => now(),
                    'updated_at' => now(),
                ], //User
                [
                    'user_id' => 5,
                    'created_at' => now(),
                    'updated_at' => now(),
                ], //User
                [
                    'user_id' => 6,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]
        );
    }
}
