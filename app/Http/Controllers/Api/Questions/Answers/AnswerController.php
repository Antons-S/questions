<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Questions\Answers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AnswerController extends Controller
{
    // TODO add contructor and inject laravel globals e.g response()

    /**
     * Store new answer
     *
     * @method POST
     */
    public function store(Request $request): JsonResponse
    {
        return response()->json([], Response::HTTP_CREATED);
    }
}
