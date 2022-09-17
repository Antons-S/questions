<?php

declare(strict_types=1);

namespace App\Repositories\Questions\Questions;

use stdClass;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\Questions\Answer\Answer;
use App\Models\Questions\Question\Question;

class QuestionDbRepository
{
    public function __construct(private readonly Question $questionModel)
    {
    }

    // TODO reformat, may be extract to special class
    public function getGraphQuestionsSummary(): Collection
    {
        $graphQuestions = $this->questionModel->graph()->get();

        $graphQuestionsStats = collect();
        // TODO test performance more
        $graphQuestions->each(function (Question $question) use (&$graphQuestionsStats) {
            $stats = DB::table(Answer::TABLE)
                ->where(Answer::QUESTION_ID, '=', $question->getId())
                ->select(Answer::QUESTION_ID, Answer::VALUE, DB::raw('count(*) as totalAnswers'), DB::raw('AVG(value) as average'))
                ->groupBy(DB::raw(implode(',', [Answer::QUESTION_ID, Answer::VALUE]) . ' WITH ROLLUP'))
                ->get();

            $formattedStats = [
                Answer::QUESTION_ID => $question->getId()
            ];

            $answersStats = collect();
            $stats->each(function (stdClass $row) use (&$answersStats, &$formattedStats) {
                if ($row->{Answer::QUESTION_ID} !== null && $row->{Answer::VALUE} !== null) {
                    $entry = [
                        Answer::VALUE => $row->{Answer::VALUE},
                        'count' => $row->totalAnswers,
                    ];
                    $answersStats->push($entry);
                    return true;
                }

                $formattedStats['totalAnswers'] = $row->totalAnswers;
                $formattedStats['averageValue'] = $row->average;
                return false;
            });

            $formattedStats['answersPerValue'] = $answersStats;
            $graphQuestionsStats->push($formattedStats);
        });

        return $graphQuestionsStats;
    }

    // TODO reformat, may be extract to special class, Store word count in answers table when answers are splitted to two tables
    public function getFreeTextQuestionsSummary(): Collection
    {
        $freeTextQuestions = $this->questionModel->freeText()->get();
        $freeTextQuestionsStats = collect();
        // TODO test performance more
        $freeTextQuestions->each(function (Question $question) use (&$freeTextQuestionsStats) {
            $stats = DB::table(Answer::TABLE)
                ->where(Answer::QUESTION_ID, '=', $question->getId())
                ->select(
                    DB::raw('SUM( ROUND ( ( CHAR_LENGTH(value) - CHAR_LENGTH(REPLACE (value, " ", "")) ) / CHAR_LENGTH(" ") ) )AS totalWordCount'), // not 100% precise
                    DB::raw('COUNT(*) as totalAnswers ')
                )
                ->get()
                ->first();

            $formattedStats = [
                Answer::QUESTION_ID => $question->getId(),
                'totalAnswers' => (int)$stats->totalAnswers,
                'totalWordCount' => (int)$stats->totalWordCount,
            ];

            $freeTextQuestionsStats->push($formattedStats);
        });

        return $freeTextQuestionsStats;
    }
}
