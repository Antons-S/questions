<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Questions\Answers;

use App\Models\Questions\Answer\Answer;
use App\Models\Questions\Question\Question;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AnswerControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreSuccess(): void
    {
        $now = Carbon::now();
        Carbon::setTestNow($now);

        $question = Question::factory()->create();
        $value = fake()->words(mt_rand(5, 15), true);

        $payload = [
            'question_id' => $question->getId(),
            'value' => $value,
        ];

        $this->assertEquals(0, Answer::count());

        $response = $this->postJson(route('answers.store'), $payload);
        $response->assertCreated();

        $this->assertEquals(1, Answer::count());
        $this->assertEquals(
            [
                'id' => 1,
                'question_id' => $question->getId(),
                'value' => $value,
                'created_at' => $now->startOfSecond()->toISOString(),
                'updated_at' => $now->startOfSecond()->toISOString(),
            ],
            Answer::first()->toArray()
        );
    }

    public function testStoreValidationEmptyPayload(): void
    {
        $response = $this->postJson(route('answers.store'));
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(
            [
                "question_id" => [
                    "The question id field is required."
                ],
                "value" => [
                    "The value field is required."
                ]
            ]
        );
    }

    public function testStoreValidationWrongTypes(): void
    {
        $payload = [
            'question_id' => 'aaa',
            'value' => 132
        ];

        $response = $this->postJson(route('answers.store'), $payload);
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(
            [
                "question_id" => [
                    "The question id must be an integer."
                ],
                "value" => [
                    "The value must be a string."
                ]
            ]
        );
    }

    public function testStoreValidationWrongValues(): void
    {
        $payload = [
            'question_id' => mt_rand(),
            'value' => Str::random(256)
        ];

        $response = $this->postJson(route('answers.store'), $payload);
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(
            [
                "question_id" => [
                    "The selected question id is invalid."
                ],
                "value" => [
                    "The value must not be greater than 255 characters."
                ]
            ]
        );
    }

    public function testStatsSuccess(): void
    {
        $response = $this->getJson(route('answers.stats'));
        $response->assertOk();
    }
}
