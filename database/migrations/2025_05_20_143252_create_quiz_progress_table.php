<?php

use App\Models\Rps;
use App\Models\Type;
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
        $type = new Type();
        $rps = new Rps();
        Schema::create('quiz_progress', function (Blueprint $table) use ($type, $rps) {
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

            $table->foreignId('type_quiz_id');
            $table->foreignId('rps_id');
            $table->timestamps();

            $table->foreign('rps_id')->references($rps->getKeyName())->on($rps->getTable())->onDelete('cascade');
            $table->foreign('type_quiz_id')->references($type->getKeyName())->on($type->getTable())->onDelete('cascade');
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
