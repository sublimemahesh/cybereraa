<?php

namespace Database\Seeders;

use App\Models\SupportTicketStatus;
use Faker\Factory;
use Illuminate\Database\Seeder;

class TicketStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $statuses = [
            'Open', 'Hold', 'Closed'
        ];

        foreach ($statuses as $status) {
            SupportTicketStatus::create([
                'name' => $status,
                'color' => $faker->hexcolor
            ]);
        }
    }
}
