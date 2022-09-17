<?php

declare(strict_types=1);

namespace App\Http\Requests\Questions\Questions;

use Illuminate\Foundation\Http\FormRequest;

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
}
