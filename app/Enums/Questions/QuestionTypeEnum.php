<?php

declare(strict_types=1);

namespace App\Enums\Questions;

enum QuestionTypeEnum: int
{
    case GRAPH = 1;
    case FREE_TEXT = 2;
}
