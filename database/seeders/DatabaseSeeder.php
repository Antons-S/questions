<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Questions\Question\Question;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Question::factory(9)->create();
        Question::factory()->freeText()->create();
    }
}
