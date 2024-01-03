<?php

namespace Database\Seeders;

use App\Models\SupportTicketCategory;
use Faker\Factory;
use Illuminate\Database\Seeder;

class TicketCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $categories = ["Uncategorized", "Billing/Payments", "Technical question", 'Commissions', 'Refund/Return', 'Reschedule Plan'];

        foreach ($categories as $role => $category) {
            SupportTicketCategory::updateOrCreate(
                ['name' => $category,],
                ['color' => $faker->hexcolor]
            );
        }
    }
}
