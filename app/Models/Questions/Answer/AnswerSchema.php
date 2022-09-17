<?php

declare(strict_types=1);

namespace App\Models\Questions\Answer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Questions\Question\Question;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin Builder
 *
 * TODO make separate tables for specific question types
 *      for performance, storage saving and convenience reasons
 */
abstract class AnswerSchema extends Model
{
    use HasFactory;

    public const TABLE = 'answers';

    public const GRAPH_VALUE_MIN = 0;
    public const GRAPH_VALUE_MAX = 5;

    /** Model Columns */
    public const ID = 'id';
    public const QUESTION_ID = 'question_id';
    public const VALUE = 'value';

    /** Model relations */
    /** @see AnswerSchema::question() */
    public const QUESTION_RELATION = 'question';

    protected $fillable = [self::QUESTION_ID, self::VALUE];

    protected $casts = [
        self::QUESTION_ID => 'integer',
        self::VALUE => 'string'
    ];

    public function getQuestionId(): int
    {
        return $this->getAttribute(self::QUESTION_ID);
    }

    public function getValue(): string
    {
        return $this->getAttribute(self::VALUE);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
