<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $fillable = [
        'title',
        'desc',
        'minggu_ke',
        'rps_id',

        'created_by',
        'updated_by',
        'activations'
    ];
    
    public function subCpmk()
    {
        return $this->belongsToMany(SubCpmk::class, 'meeting_subcpmks', 'meeting_id', 'subcpmk_id');
    }

    public function kisi() {
        return $this->hasMany(KisiKisi::class, 'meeting_id');
    }
}
