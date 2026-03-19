<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('live_quizzes')) {
            Schema::create('live_quizzes', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->unsignedBigInteger('teacher_id')->index();
                $table->string('title', 190);
                $table->string('target_class', 64)->nullable()->index();
                $table->string('target_section', 64)->nullable()->index();
                $table->json('questions');
                $table->boolean('is_active')->default(true)->index();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('live_quiz_sessions')) {
            Schema::create('live_quiz_sessions', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('quiz_id')->index();
                $table->unsignedBigInteger('teacher_id')->index();
                $table->string('join_code', 12)->unique();
                $table->string('status', 24)->default('waiting')->index();
                $table->unsignedInteger('current_index')->default(0);
                $table->boolean('is_locked')->default(false);
                $table->unsignedBigInteger('ends_at_ms')->default(0);
                $table->json('snapshot')->nullable();
                $table->timestamp('started_at')->nullable()->index();
                $table->timestamp('finished_at')->nullable()->index();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('live_quiz_answers')) {
            Schema::create('live_quiz_answers', function (Blueprint $table) {
                $table->id();
                $table->uuid('session_id')->index();
                $table->unsignedBigInteger('user_id')->index();
                $table->unsignedInteger('question_index');
                $table->string('choice', 8)->nullable();
                $table->boolean('is_correct')->default(false)->index();
                $table->unsignedInteger('response_ms')->default(0);
                $table->unsignedBigInteger('answered_at_ms')->default(0)->index();
                $table->timestamps();
                $table->unique(['session_id', 'user_id', 'question_index']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('live_quiz_answers');
        Schema::dropIfExists('live_quiz_sessions');
        Schema::dropIfExists('live_quizzes');
    }
};
