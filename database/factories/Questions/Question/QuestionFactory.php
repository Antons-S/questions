<?php

declare(strict_types=1);

namespace Database\Factories\Questions\Question;

use App\Enums\Questions\QuestionTypeEnum;
use App\Models\Questions\Question\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    public function definition(): array
    {
        return [
            Question::ID => fake()->unique()->numberBetween(1000, 100000),
            Question::TYPE_ID => QuestionTypeEnum::GRAPH,
            Question::TITLE => fake()->words(mt_rand(3, 7), true),
            Question::TEXT => fake()->words(mt_rand(5, 20), true),
        ];
    }

    public function freeText(): static
    {
        return $this->state(fn (array $attributes) => [
            Question::TYPE_ID => QuestionTypeEnum::FREEE_TEXT,
        ]);
    }
}
