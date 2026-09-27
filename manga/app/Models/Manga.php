<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Manga extends Model
{
    protected $fillable = [
        'titre',
    ];

    public function tomes(): HasMany
    {
        return $this->hasMany(Tome::class);
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'genre_manga');
    }
}