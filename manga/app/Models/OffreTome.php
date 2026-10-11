<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OffreTome extends Model
{
    protected $table = 'offres_tomes';

    protected $fillable = [
        'tome_recherche_id',
        'boutique',
        'prix',
        'url',
        'disponible',
    ];

    protected $casts = [
        'prix' => 'decimal:2',
        'disponible' => 'boolean',
    ];

    public function tomeRecherche(): BelongsTo
    {
        return $this->belongsTo(TomeRecherche::class);
    }
}