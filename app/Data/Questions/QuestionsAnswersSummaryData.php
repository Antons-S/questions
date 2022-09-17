<?php

declare(strict_types=1);

namespace App\Data\Questions;

use Illuminate\Support\Collection;

class QuestionsAnswersSummaryData
{
    private Collection $graphQuestionsSummary;
    private Collection $freeTextQuestionsSummary;

    public function setGraphQuestionsSummary(Collection $graphQuestionsSummary): static
    {
        $this->graphQuestionsSummary = $graphQuestionsSummary;
        return $this;
    }

    public function getGraphQuestionsSummary(): Collection
    {
        return $this->graphQuestionsSummary;
    }

    public function setFreeTextQuestionsSummary(Collection $freeTextQuestionsSummary): static
    {
        $this->freeTextQuestionsSummary = $freeTextQuestionsSummary;
        return $this;
    }

    public function getFreeTextQuestionsSummary(): Collection
    {
        return $this->freeTextQuestionsSummary;
    }
}
