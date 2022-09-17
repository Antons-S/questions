<?php

declare(strict_types=1);

namespace App\Repositories\Questions\Answers;

use Illuminate\Support\Facades\DB;
use App\Models\Questions\Answer\Answer;
use App\Models\Questions\Question\Question;
use stdClass;

class AnswerDbRepository
{
    public function __construct(private readonly Answer $answerModel, private readonly Question $questionModel)
    {
    }

    // TODO return created instance if need to
    public function store(int $questionId, string $value): void
    {
        $this->answerModel->create([
            Answer::QUESTION_ID => $questionId,
            Answer::VALUE => $value,
        ]);
    }

    // TODO reformat, don't return array, may be extract to special class
    public function getStats()
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
            $graphQuestionsStats->push($formattedStats); // 2.2 - 2.3s
        });

        return [
            'questions' => [
                'graphQuestions' => $graphQuestionsStats
            ]
        ];
    }
}
