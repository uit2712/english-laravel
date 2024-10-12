<?php

use Core\Features\Question\Constants\QuestionConstants;
use Core\Features\Topic\Constants\TopicConstants;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(QuestionConstants::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title', 750);
            $table->string('answer_a', 750);
            $table->string('answer_b', 750);
            $table->string('answer_c', 750)->nullable();
            $table->string('answer_d', 750)->nullable();
            $table->string('answer_e', 750)->nullable();
            $table->string('right_answers')->comment('Example: a,b');
            $table->foreignId('topic_id')->constrained(TopicConstants::TABLE_NAME);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
