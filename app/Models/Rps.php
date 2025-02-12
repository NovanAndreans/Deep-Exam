<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function subCpmk() {
        return $this->hasMany(SubCpmk::class, 'cpmk_id');
    }

    public function meeting() {
        return $this->hasMany(Meeting::class, 'rps_id');
    }
}
