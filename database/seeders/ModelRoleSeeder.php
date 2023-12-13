<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModelRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('model_has_roles')->insert(
            [
                // super_admin
                [
                    'role_id' => '1',
                    'model_id' => '1',
                    'model_type' => User::class,
                ],
                // admin
                [
                    'role_id' => '2',
                    'model_id' => '2',
                    'model_type' => User::class,
                ],
                // user
                [
                    'role_id' => '3',
                    'model_id' => '3',
                    'model_type' => User::class,
                ],// user
                [
                    'role_id' => '3',
                    'model_id' => '4',
                    'model_type' => User::class,
                ],// user
                [
                    'role_id' => '3',
                    'model_id' => '5',
                    'model_type' => User::class,
                ],// user
                [
                    'role_id' => '3',
                    'model_id' => '6',
                    'model_type' => User::class,
                ],
            ]
        );
    }
}
