<?php

declare(strict_types=1);

namespace Database\Factories\Questions\Answer;

use App\Models\Questions\Answer\Answer;
use App\Models\Questions\Question\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnswerFactory extends Factory
{
    public function definition(): array
    {
        return [
            Answer::ID => fake()->unique()->numberBetween(1000, 100000),
            Answer::QUESTION_ID => Question::factory(),
            Answer::VALUE => fake()->numberBetween(0, 5),
        ];
    }

    public function freeText(): static
    {
        return $this->state(fn (array $attributes) => [
            Answer::VALUE => fake()->words(mt_rand(1, 20), true),
        ]);
    }
}
