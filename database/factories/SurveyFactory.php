<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SurveyFactory extends Factory
{
    public function definition(): array
    {
        $questions = [
            "Jaki jest Twój ulubiony kolor?",
            "Jak często uprawiasz sport?",
            "Czy lubisz kawę czy herbatę?",
            "Czy pracujesz zdalnie?",
            "Czy masz zwierzęta domowe?"
        ];
        $faker = Factory::create('pl_PL');
        return [
            'user_id'    => User::inRandomOrder()->first()->id ?? 1,
            'uuid'       => Str::uuid(),
            'title'      => $faker->randomElement($questions),
            'description'=> $faker->sentence(),
            'is_public'  => true,
            'is_named'   => false,
            'expires_at' => null,
        ];
    }
}