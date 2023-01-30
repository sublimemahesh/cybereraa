<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(ModelRoleSeeder::class);
        $this->call(TeamSeeder::class);
        $this->call(PackageSeeder::class);
        $this->call(PageSeeder::class);
        $this->call(StrategySeeder::class);
        $this->call(TicketCategoriesTableSeeder::class);
        $this->call(TicketPrioritiesTableSeeder::class);
        $this->call(TicketStatusesTableSeeder::class);

    }
}
