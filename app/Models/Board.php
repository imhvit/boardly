<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Board extends Model
{
    protected $fillable = [
        'title',
        'owner_id',
    ];

    protected static function booted()
    {
        static::creating(function ($board) {

            do {
                $id = Str::random(8);
            } while (self::where('public_id', $id)->exists());

            $board->public_id = $id;
        });
    }
}
