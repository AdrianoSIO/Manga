<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Genre extends Model
{
    protected $fillable = [
        'nom',
    ];

    public function mangas(): BelongsToMany
    {
        return $this->belongsToMany(
            Manga::class,
            'genre_manga'
        );
    }
}