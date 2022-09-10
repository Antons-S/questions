<?php

namespace App\Models\Questions\QuestionType;

use Illuminate\Database\Eloquent\Model;
use App\Models\Questions\Question\Question;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

abstract class QuestionTypeSchema extends Model
{
    use HasFactory;

    /** Model Columns */
    public const ID = 'id';
    public const NAME = 'name';

    /** Model relations */
    /** @see QuestionTypeSchema::questions() */
    public const QUESTIONS_RELATION = 'questions';

    protected $fillable = [self::NAME];
    protected $casts = [self::NAME => 'string'];

    public function getName(): string
    {
        return $this->getAttribute(self::NAME);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, Question::TYPE_ID);
    }
}
