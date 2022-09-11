<?php

declare(strict_types=1);

namespace App\Http\Requests\Questions\Answers;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnswerRequest extends FormRequest
{
    public function authorize(): bool
    {
        // TODO use Permissions, Gates and Policies
        return true;
    }

    public function rules(): array
    {
        // TODO extract hardcoded strings and rules to ValidationHelper
        return [
            'question_id' => 'required|integer|exists:questions,id',
            'value' => 'required|string|max:255',
        ];
    }
}
