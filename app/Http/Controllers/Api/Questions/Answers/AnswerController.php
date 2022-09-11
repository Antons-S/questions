<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Questions\Answers;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Questions\Answers\StoreAnswerRequest;

class AnswerController extends Controller
{
    // TODO add contructor and inject laravel globals e.g response()

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
        return response()->json([], Response::HTTP_CREATED);
    }
}
