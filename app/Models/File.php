<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'transtypeid',
        'refid',
        'directories',
        'filename',
        'mimetype',
        'filesize',

        'created_by',
        'updated_by',
        'activations'
    ];

    public static function boot()
    {
        parent::boot();

        static::deleted(function ($item) {
            Storage::disk('public')->delete("$item->directories$item->filename");
        });

        static::deleting(function ($item) {
            Storage::disk('public')->delete("$item->directories$item->filename");
        });
    }

    public function transtype()
    {
        return $this->belongsTo(Type::class, 'transtypeid');
    }
}
