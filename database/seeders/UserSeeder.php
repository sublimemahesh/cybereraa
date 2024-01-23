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
                    'name' => 'Super Admin',
                    'username' => 'super_admin',
                    'email' => 'noreply@tycoon1m.com',
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
                    'email' => 'noreply@tycoon1m.com',
                    'email_verified_at' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                ],
                //User
                [
                    'super_parent_id' => null,
                    'name' => 'Alex John',
                    'username' => 'Alex',
                    'email' => 'noreply@tycoon1m.com',
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                ],
                //User
                [
                    'super_parent_id' => 3,
                    'name' => 'Anna Asler',
                    'username' => 'Anna',
                    'email' => 'noreply@tycoon1m.com',
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                ],
                //User
                [
                    'super_parent_id' => 4,
                    'name' => 'Debra Hiles',
                    'username' => 'Debra',
                    'email' => 'noreply@tycoon1m.com',
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                ],
                //User
                [
                    'super_parent_id' => 5,
                    'name' => 'Tycoon 1M',
                    'username' => 'Tycoon1m',
                    'email' => 'noreply@tycoon1m.com',
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
