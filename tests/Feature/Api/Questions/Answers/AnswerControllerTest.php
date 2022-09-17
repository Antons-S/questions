<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Questions\Answers;

use App\Models\Questions\Answer\Answer;
use App\Models\Questions\Question\Question;
use Carbon\Carbon;
use Database\Seeders\DatabaseSeeder;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AnswerControllerTest extends TestCase
{
    use RefreshDatabase;

    private DatabaseSeeder $databaseSeeder;

    public function setUp(): void
    {
        parent::setUp();

        $this->databaseSeeder = $this->app->make(DatabaseSeeder::class);
    }

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

    public function testStatsGraphQuestionsQuestion(): void
    {
        /** @var Collection<Question> $graphQuestions */
        $graphQuestions = Question::factory(4)->create();

        $question2Values = [2, 4];
        foreach ($question2Values as $value) {
            $graphQuestions[1]->answers()->create([Answer::VALUE => $value]);
        }

        $question3Values = [0, 0, 0, 0, 1, 2, 3, 4, 5];
        foreach ($question3Values as $value) {
            $graphQuestions[2]->answers()->create([Answer::VALUE => $value]);
        }

        $question4Values = [1, 1, 0, 2, 2, 2, 2, 3, 4, 5, 5, 5];
        foreach ($question4Values as $value) {
            $graphQuestions[3]->answers()->create([Answer::VALUE => $value]);
        }

        $response = $this->getJson(route('answers.stats'));
        $response->assertOk();

        $expectedGraphQuestionsStats = [
            [
                "question_id" => $graphQuestions[3]->getId(),
                "totalAnswers" => 12,
                "averageValue" => 2.6666666666667,
                "answersPerValue" => [
                    [
                        "value" => "0",
                        "count" => 1
                    ],
                    [
                        "value" => "1",
                        "count" => 2
                    ],
                    [
                        "value" => "2",
                        "count" => 4
                    ],
                    [
                        "value" => "3",
                        "count" => 1
                    ],
                    [
                        "value" => "4",
                        "count" => 1
                    ],
                    [
                        "value" => "5",
                        "count" => 3
                    ]
                ]
            ],
            [
                "question_id" => $graphQuestions[1]->getId(),
                "totalAnswers" => 2,
                "averageValue" => 3,
                "answersPerValue" => [
                    [
                        "value" => "2",
                        "count" => 1
                    ],
                    [
                        "value" => "4",
                        "count" => 1
                    ]
                ]
            ],
            [
                "question_id" => $graphQuestions[2]->getId(),
                "totalAnswers" => 9,
                "averageValue" => 1.6666666666667,
                "answersPerValue" => [
                    [
                        "value" => "0",
                        "count" => 4
                    ],
                    [
                        "value" => "1",
                        "count" => 1
                    ],
                    [
                        "value" => "2",
                        "count" => 1
                    ],
                    [
                        "value" => "3",
                        "count" => 1
                    ],
                    [
                        "value" => "4",
                        "count" => 1
                    ],
                    [
                        "value" => "5",
                        "count" => 1
                    ]
                ]
            ],
            [
                "question_id" => $graphQuestions[0]->getId(),
                "answersPerValue" => []
            ]
        ];

        $expectedGraphQuestionsStats = collect($expectedGraphQuestionsStats)->sortBy('question_id')->values()->toArray();

        $this->assertEquals($expectedGraphQuestionsStats,$response->json('questions.graphQuestions'));
    }
}
