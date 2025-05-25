<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class OptionFactory extends Factory
{
    public function definition(): array
    {
        $possible = [
            ['Czerwony', 'Niebieski'],
            ['Codziennie', 'Nigdy'],
            ['Kawa', 'Herbata'],
            ['Tak', 'Nie'],
            ['Tak', 'Nie'] 
        ];
        return [
            'question_id'   => Question::inRandomOrder()->first()->id ?? 1,
            'option_text'   => $this->faker->randomElement(['Tak', 'Nie']), 
            'option_order'  => 1,
        ];
    }
}