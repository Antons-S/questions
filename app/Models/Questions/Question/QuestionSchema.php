<?php

declare(strict_types=1);

namespace App\Models\Questions\Question;

use Illuminate\Database\Eloquent\Model;
use App\Enums\Questions\QuestionTypeEnum;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Questions\QuestionType\QuestionType;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @mixin Builder
 */
abstract class QuestionSchema extends Model
{
    use HasFactory;

    /** Model Columns */
    public const ID = 'id';
    public const TYPE_ID = 'type_id';
    public const TITLE = 'title';
    public const TEXT = 'text';

    /** Model relations */
    /** @see QuestionSchema::type() */
    public const TYPE_RELATION = 'type';

    protected $fillable = [self::TYPE_ID, self::TITLE, self::TEXT];

    protected $casts = [
        self::ID => 'integer',
        self::TYPE_ID => QuestionTypeEnum::class,
        self::TITLE => 'string',
        self::TEXT => 'string',
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(QuestionType::class);
    }

    public function getId(): int
    {
        return $this->getAttribute(self::ID);
    }

    public function getTypeid(): QuestionTypeEnum
    {
        return $this->getAttribute(self::TYPE_ID);
    }

    public function getTitle(): string
    {
        return $this->getAttribute(self::TITLE);
    }

    public function getText(): string
    {
        return $this->getAttribute(self::TEXT);
    }
}
