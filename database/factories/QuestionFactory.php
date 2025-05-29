<?php

namespace Database\Factories;

use App\Models\Survey;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'question_text' => 'To samo co tytuł ankiety',
            'question_type' => 'single',
            'question_order'=> 1,
        ];
    }
}