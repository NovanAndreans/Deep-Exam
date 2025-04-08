<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizSetting extends Model
{
    protected $fillable = [
        'jumlah_soal',
        'batas_waktu',
        'attempt_quiz',
        'soal_per_sesi',
        'rps_id'
    ];
}
