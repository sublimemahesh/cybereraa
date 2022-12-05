<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

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
                    'model_type' => 'App\Models\User',
                ],
                // admin
                [
                    'role_id' => '2',
                    'model_id' => '2',
                    'model_type' => 'App\Models\User',
                ],
                // user
                [
                    'role_id' => '3',
                    'model_id' => '3',
                    'model_type' => 'App\Models\User',
                ],
            ]
        );
    }
}
