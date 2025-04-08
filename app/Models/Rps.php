<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Rps extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'desc',
        'cpmk',
        'status_id',

        'created_by',
        'updated_by',
        'activations'
    ];

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function subCpmk() {
        return $this->hasMany(SubCpmk::class, 'cpmk_id');
    }

    public function meeting() {
        return $this->hasMany(Meeting::class, 'rps_id');
    }

    public function quizSetting() {
        return $this->hasOne(QuizSetting::class, 'rps_id');
    }
}
