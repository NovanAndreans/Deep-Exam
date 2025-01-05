<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
    use HasFactory;

    protected $table = 'permissions';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'role',
        'permisfeatid',
        'hasaccess',

        'created_by',
        'updated_by',
        'activations'
    ];

    public function feature()
    {
        return $this->belongsTo(Feature::class, 'permisfeatid');
    }
}
