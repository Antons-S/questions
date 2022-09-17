<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Questions\Questions;

use App\Models\Questions\Answer\Answer;
use App\Models\Questions\Question\Question;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuestionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testSummaryGraphQuestions(): void
    {
        $this->withoutExceptionHandling();

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

        $response = $this->getJson(route('questions.summary'));
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

        $this->assertEquals($expectedGraphQuestionsStats, $response->json('questions.graphQuestions'));
    }
}
