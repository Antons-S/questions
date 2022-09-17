<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Questions\Answers\AnswerController;
use App\Http\Controllers\Api\Questions\Questions\QuestionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// TODO put inside auth
Route::group(['prefix' => 'answers'], function () {
    Route::post('/', [AnswerController::class, 'store'])->name('answers.store');
});

Route::group(['prefix' => 'questions'], function () {
    Route::get('/summary', [QuestionController::class, 'getSummary'])->name('questions.summary');
});
