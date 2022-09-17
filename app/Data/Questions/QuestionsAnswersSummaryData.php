<?php

declare(strict_types=1);

namespace App\Data\Questions;

use Illuminate\Support\Collection;

class QuestionsAnswersSummaryData
{
    private Collection $graphQuestionsSummary;

    public function setGraphQuestionsSummary(Collection $graphQuestionsSummary): static
    {
        $this->graphQuestionsSummary = $graphQuestionsSummary;
        return $this;
    }

    public function getGraphQuestionsSummary(): Collection
    {
        return $this->graphQuestionsSummary;
    }
}
