<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Questions\Answers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

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

}
