<?php

declare(strict_types=1);

namespace App\Enums\Questions;

enum QuestionTypeEnum: int
{
    case Graph = 1;
    case FreeText = 2;
}
