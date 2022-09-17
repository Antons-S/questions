<?php

declare(strict_types=1);

namespace App\Http\Resources\Questions\Questions;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionsAnswersSummaryResource extends JsonResource
{

    /**
     * @var QuestionsAnswersSummaryData $resource
     */
    public $resource;

    public function toArray($request): array
    {
        return [
            'questions' => [
                'graphQuestions' => $this->resource->getGraphQuestionsSummary(),
            ]
        ];
    }
}
