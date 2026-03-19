<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Board extends Model
{
    protected $fillable = [
        'title',
        'description',
        'tag',
        'visibility',
    ];

    protected static function booted()
    {
        static::creating(function ($board) {
            do {
                $id = Str::random(8);
            } while (self::where('public_id', $id)->exists());

            $board->public_id = $id;
            $board->owner_id = Auth::id();
        });
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function columns()
    {
        return $this->hasMany(Column::class)->orderBy('position', 'asc');
    }
}
