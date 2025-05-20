<?php

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
        Schema::create('quiz_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('total_duration');
            $table->integer('correct_count');
            $table->integer('wrong_count');
            $table->decimal('correct_percent', 5, 2);
            $table->json('time_spend_sessions')->nullable();
            $table->json('skip_question_sessions')->nullable();
            $table->json('change_answer_sessions')->nullable();
            $table->json('hint_sessions')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_progress');
    }
};
