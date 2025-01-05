<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feature extends Model
{
    use HasFactory;

    protected $table = 'features';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'featmenuid',
        'feattitle',
        'featslug',
        'featuredesc',

        'created_by',
        'updated_by',
        'activations'
    ];

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'permisfeatid');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'featmenuid');
    }
}
