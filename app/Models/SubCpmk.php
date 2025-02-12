<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCpmk extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'subcpmk',
        'cpmk_id'
    ];

    public function rps() {
        return $this->belongsTo(Rps::class, 'cpmk_id');
    }
}
