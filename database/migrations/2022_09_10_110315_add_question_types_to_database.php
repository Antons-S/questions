<?php

declare(strict_types=1);

use Illuminate\Support\Arr;
use Illuminate\Database\Migrations\Migration;
use App\Models\Questions\QuestionType\QuestionType;

return new class extends Migration
{
    const TYPES = [
        ['id' => 1, 'name' => 'Graph'],
        ['id' => 2, 'name' => 'Free Text'],
    ];

    public function up(): void
    {
        QuestionType::unguard();

        foreach (self::TYPES as $type) {
            QuestionType::create($type);
        }

        QuestionType::reguard();
    }

    public function down(): void
    {
        $ids = Arr::pluck(self::TYPES, QuestionType::ID);
        QuestionType::whereIn(QuestionType::ID, $ids)->forceDelete();
    }
};
