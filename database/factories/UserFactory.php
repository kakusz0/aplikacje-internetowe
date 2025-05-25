<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserFactory extends Factory
{
    public function definition(): array
    {
        $faker = Factory::create('pl_PL');
        return [
            'first_name' => $faker->firstName,
            'last_name'  => $faker->lastName,
            'email'      => $faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password'   => bcrypt('haslo'), 
            'remember_token' => Str::random(10),
        ];
    }
}
