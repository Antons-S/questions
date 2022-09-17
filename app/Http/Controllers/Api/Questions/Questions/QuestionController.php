<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Questions\Questions;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Repositories\Questions\Questions\QuestionLogicRepository;
use App\Http\Requests\Questions\Questions\GetQuestionsAnswersSummaryRequest;

class QuestionController extends Controller
{
    // TODO inject Laravel globals helper that contains needed globals e.g response()
    public function __construct(private readonly QuestionLogicRepository $questionLogicRepository)
    {
    }

    /**
     *
     * TODO add caching, return resource, move under questions?
     *
     * Get stats about all types of questions
     *
     * @method GET
     */
    public function getSummary(GetQuestionsAnswersSummaryRequest $request): JsonResponse
    {
        return response()->json($this->questionLogicRepository->getSummary());
    }
}
