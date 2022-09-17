<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Questions\Answer\Answer;
use App\Models\Questions\Question\Question;
use Illuminate\Support\Collection;

class DatabaseSeeder extends Seeder
{
    const ANSWERS_PER_QUESTION_DEFAULT = 100000;

    public function run(int $answersPerQuestion = self::ANSWERS_PER_QUESTION_DEFAULT): void
    {
        $graphQuestions = Question::factory(9)->create();
        $freeTextQuestion = Question::factory()->freeText()->create();

        $graphQuestions->each(fn (Question $question) => $this->seedAnswers($question->id, $answersPerQuestion + mt_rand(10, 50)));
        $this->seedAnswers($freeTextQuestion->id, $answersPerQuestion, isFreeText: true);
    }

    private function seedAnswers(int $questionId, int $amount = 1000, bool $isFreeText = false)
    {
        $now = now();
        collect(range(1, $amount))->chunk(500)->each(function (Collection $chunk) use ($now, $questionId, $isFreeText) {
            $payload = [];
            $chunk->each(function () use ($now, &$payload, $questionId, $isFreeText) {
                $payload[] = [
                    Answer::QUESTION_ID => $questionId,
                    Answer::VALUE => $isFreeText ? fake()->words(mt_rand(1, 20), true) : mt_rand(0, 5),
                    Answer::CREATED_AT => $now,
                    Answer::UPDATED_AT => $now,
                ];
            });
            DB::table('answers')->insert($payload);
        });
    }
}
