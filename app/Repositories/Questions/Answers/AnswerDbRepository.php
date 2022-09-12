<?php

declare(strict_types=1);

namespace App\Repositories\Questions\Answers;

use App\Models\Questions\Answer\Answer;

class AnswerDbRepository
{
    public function __construct(private readonly Answer $answerModel)
    {
    }

    // TODO return created instance if need to
    public function store(int $questionId, string $value): void
    {
        $this->answerModel->create([
            Answer::QUESTION_ID => $questionId,
            Answer::VALUE => $value,
        ]);
    }

    public function getStats(){
        
    }
}
