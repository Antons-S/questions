<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Questions\Answers;

use Tests\TestCase;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AnswerControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreItReturnsCreated(): void
    {
        $response = $this->postJson(route('answers.store'));
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function testStoreValidationEmptyPayload(): void
    {
        $response = $this->postJson(route('answers.store'));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
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
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
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
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
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
}
