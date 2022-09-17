<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Questions\Answers;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Questions\Answers\StoreAnswerRequest;
use App\Repositories\Questions\Answers\AnswerLogicRepository;
use App\Http\Requests\Questions\Answers\GetAnswersStatsRequest;

class AnswerController extends Controller
{
    // TODO inject Laravel globals helper that contains needed globals e.g response()
    public function __construct(private readonly AnswerLogicRepository $answerLogicRepository)
    {
    }

    /**
     * Store new answer
     *
     * Normally questions would be connected to poll
     * or something else and answers would be saved in bulk
     * but for simplification answers are saved by one
     *
     * @method POST
     */
    public function store(StoreAnswerRequest $request): JsonResponse
    {
        /** TODO use DTO instead of request->get() @see https://github.com/spatie/data-transfer-object */
        $this->answerLogicRepository->store($request->get('question_id'), $request->get('value'));
        return response()->json([], Response::HTTP_CREATED);
    }

    /**
     *
     * TODO add caching, return resource, move under questions?
     *
     * Get stats about all types of questions
     *
     * @method GET
     */
    public function getStats(GetAnswersStatsRequest $request): JsonResponse
    {
        return response()->json($this->answerLogicRepository->getStats());
    }
}
