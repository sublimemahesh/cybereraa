<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProfileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'street' => $this->faker->streetName(),
            'state' => $this->faker->word(),
            'address' => $this->faker->address(),
            'zip_code' => $this->faker->postcode(),
            'home_phone' => $this->faker->phoneNumber(),
            'dob' => $this->faker->date(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
