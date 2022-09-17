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
        $graphQuestionSummary = $this->questionDbRepository->getGraphQuestionsSummary();

        $summary = new QuestionsAnswersSummaryData();
        $summary->setGraphQuestionsSummary($graphQuestionSummary);

        return $summary;
    }
}
