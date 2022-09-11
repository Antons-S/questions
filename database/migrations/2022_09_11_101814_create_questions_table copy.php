<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_id');
            /**
             * Here could be more relations like user_id/venue_id/poll_id/quiz_id etc
             */
            $table->string('value');
            $table->timestamps();

            $table->foreign('question_id')->references('id')->on('questions');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
