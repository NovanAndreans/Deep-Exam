<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menus';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'masterid',
        'menunm',
        'menuroute',
        'menuseq',
        'menuicon',

        'created_by',
        'updated_by',
        'activations'
    ];

    public function features()
    {
        return $this->hasMany(Feature::class, 'featmenuid');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'masterid');
    }
}
