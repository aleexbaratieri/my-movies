<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Movie extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'user_id',
        'movie_id',
        'original_title',
        'title',
        'poster_path',
        'watched',
        'favorite',
        'watch_later',
    ];

    protected $casts = [
        'watched' => 'boolean',
        'favorite' => 'boolean',
        'watch_later' => 'boolean',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'user_id');
    }
}
