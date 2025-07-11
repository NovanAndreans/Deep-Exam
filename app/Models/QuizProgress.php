<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizProgress extends Model
{
    protected $fillable = [
        'user_id',
        'total_duration',
        'correct_count',
        'wrong_count',
        'correct_percent',
        'time_spend_sessions',
        'skip_question_sessions',
        'change_answer_sessions',
        'hint_sessions',
        'type_quiz_id',
        'rps_id',
    ];

    protected $casts = [
        'time_spend_sessions' => 'array',
        'skip_question_sessions' => 'array',
        'change_answer_sessions' => 'array',
        'hint_sessions' => 'array',
    ];
}
