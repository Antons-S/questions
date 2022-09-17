<?php

declare(strict_types=1);

namespace App\Repositories\Questions\Questions;

use App\Repositories\Questions\Questions\QuestionDbRepository;

class QuestionLogicRepository
{
    public function __construct(private readonly QuestionDbRepository $questionDbRepository)
    {
    }

    public function getSummary()
    {
        return $this->questionDbRepository->getSummary();
    }
}
