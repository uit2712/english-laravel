<?php

use Core\Features\Topic\Constants\TopicConstants;
use Core\Features\Vocabulary\Constants\VocabularyConstants;
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
        Schema::create(VocabularyConstants::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name', 500);
            $table->string('pronunciation', 500)->nullable();
            $table->string('meaning', 500);
            $table->string('image', 200)->nullable();
            $table->foreignId('topic_id')->constrained(TopicConstants::TABLE_NAME);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(VocabularyConstants::TABLE_NAME);
    }
};
