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
        $timeStart = now();
        $graphQuestions = Question::factory(9)->create();
        $freeTextQuestion = Question::factory()->freeText()->create();

        $graphQuestions->each(fn (Question $question) => $this->seedAnswers($question->id, $answersPerQuestion + mt_rand(10,50)));
        $this->seedAnswers($freeTextQuestion->id, $answersPerQuestion, isFreeText: true);

        dump('Time spent: ' . now()->diffInMilliseconds($timeStart) . 'ms');

        // speed tests
        // Answer::factory(10000)->create([Answer::QUESTION_ID => 1]); // 16s for 10k

        // foreach (range(1, 10000) as $i) {
        // Answer::create([
        //     Answer::QUESTION_ID => 1,
        //     Answer::VALUE => mt_rand(0, 5), // 16s for 10k
        // ]);

        // Answer::insert([
        //     Answer::QUESTION_ID => 1,
        //     Answer::VALUE => mt_rand(0, 5),
        //     Answer::CREATED_AT => $timeStart,
        //     Answer::UPDATED_AT => $timeStart, // 16s for 10k
        // ]);

        // DB::table('answers')->insert(
        //     [
        //         Answer::QUESTION_ID => 1,
        //         Answer::VALUE => mt_rand(0, 5),
        //         Answer::CREATED_AT => $timeStart,
        //         Answer::UPDATED_AT => $timeStart, // 14s for 10k
        //     ]
        // );
        // }

        // collect(range(1, 10000))->chunk(500)->each(function (Collection $chunk) use ($timeStart) {
        //     $payload = [];
        //     $chunk->each(function () use ($timeStart, &$payload) {
        //         $payload[] = [
        //             Answer::QUESTION_ID => 1,
        //             Answer::VALUE => mt_rand(0, 5),
        //             Answer::CREATED_AT => $timeStart,
        //             Answer::UPDATED_AT => $timeStart,
        //         ];
        //     });
        //     DB::table('answers')->insert($payload); // 294ms for 10k
        // });
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
