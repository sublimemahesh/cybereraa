<?php

namespace Database\Seeders;

use App\Models\SupportTicketPriority;
use Faker\Factory;
use Illuminate\Database\Seeder;

class TicketPrioritiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $priorities = [
            'Low', 'Medium', 'High'
        ];

        foreach ($priorities as $priority) {
            SupportTicketPriority::create([
                'name' => $priority,
                'color' => $faker->hexcolor
            ]);
        }
    }
}
