<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TomeRecherche extends Model
{
    protected $table = 'tomes_recherches';

    protected $fillable = [
        'user_id',
        'manga_id',
        'numero',
    ];

    protected $casts = [
        'numero' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function manga(): BelongsTo
    {
        return $this->belongsTo(Manga::class);
    }

    public function offres(): HasMany
    {
        return $this->hasMany(OffreTome::class);
    }
}