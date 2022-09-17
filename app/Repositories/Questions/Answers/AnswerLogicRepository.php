<?php

declare(strict_types=1);

namespace App\Repositories\Questions\Answers;

use App\Repositories\Questions\Answers\AnswerDbRepository;

class AnswerLogicRepository
{
    public function __construct(private readonly AnswerDbRepository $answerDbRepository)
    {
    }

    // TODO expect DTO as argument
    public function store(int $questionId, string $value): void
    {
        $this->answerDbRepository->store($questionId, $value);
    }
}
