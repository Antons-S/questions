<?php

declare(strict_types=1);

namespace App\Repositories\Questions\Questions;

use App\Data\Questions\QuestionsAnswersSummaryData;
use App\Repositories\Questions\Questions\QuestionDbRepository;

class QuestionLogicRepository
{
    public function __construct(private readonly QuestionDbRepository $questionDbRepository)
    {
    }

    public function getSummary(): QuestionsAnswersSummaryData
    {
        $summary = new QuestionsAnswersSummaryData();
        return $summary
            ->setGraphQuestionsSummary($this->questionDbRepository->getGraphQuestionsSummary())
            ->setFreeTextQuestionsSummary($this->questionDbRepository->getFreeTextQuestionsSummary());
    }
}
