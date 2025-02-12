<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KisiKisi extends Model
{
    protected $fillable = [
        'taksonomi_bloom',
        'type',
        'kisi_kisi',
        'meeting_id'
    ];
}
