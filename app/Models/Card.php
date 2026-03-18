<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Pest\Support\Str;

class Card extends Model
{
    protected $fillable = [
        'title',
        'description',
        'is_completed',
        'end_date',
        'column_id'
    ];

    protected static function booted()
    {
        static::creating(function ($card) {
            do {
                $id = Str::random(8);
            } while (self::where('public_id', $id)->exists());

            $card->public_id = $id;
            $card->owner_id = Auth::id();
        });
    }

    public function column()
    {
        return $this->belongsTo(Column::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
