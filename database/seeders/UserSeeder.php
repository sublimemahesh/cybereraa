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
                    'name' => 'Navod Hansajith',
                    'username' => 'super_admin',
                    'email' => 'hansajith.synotec@gmail.com',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                ],
                //Admin
                [
                    'name' => 'James caron',
                    'username' => 'admin',
                    'email' => 'hansajithsynotec@gmail.com',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                ],
                //User
                [
                    'name' => 'john smith',
                    'username' => 'user',
                    'email' => 'hansajith18@gmail.com',
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
                ],
            ]
        );
    }
}
