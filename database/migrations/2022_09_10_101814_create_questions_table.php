<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_id');
            /**
             * Here could be more relations like entity_id/venue_id/poll_id etc
             */
            $table->string('title');
            $table->text('text');
            $table->timestamps();

            $table->foreign('type_id')->references('id')->on('question_types');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
