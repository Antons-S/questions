<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Questions\Answers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnswerControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreItReturnsCreated(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
