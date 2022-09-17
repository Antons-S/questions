<?php

declare(strict_types=1);

namespace App\Http\Requests\Questions\Questions;

use Illuminate\Foundation\Http\FormRequest;
use App\Data\Questions\QuestionsAnswersSummaryData;
use App\Http\Resources\Questions\Questions\QuestionsAnswersSummaryResource;

class GetQuestionsAnswersSummaryRequest extends FormRequest
{
    public function authorize(): bool
    {
        // TODO use Permissions, Gates and Policies
        return true;
    }

    public function rules(): array
    {
        // TODO add rules for filters and stuff
        return [];
    }

    public function responseResource(QuestionsAnswersSummaryData $summary): QuestionsAnswersSummaryResource
    {
        return new QuestionsAnswersSummaryResource($summary);
    }
}
