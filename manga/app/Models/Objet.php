<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Objet extends Model
{
    protected $fillable = [
        'user_id',
        'nom',
        'categorie',
        'prix',
        'prix_cible',
        'url',
        'importance',
        'disponible',
        'achete',
        'description',
        'date_ajout',
        'date_achat',
    ];

    protected $casts = [
        'prix' => 'decimal:2',
        'prix_cible' => 'decimal:2',
        'disponible' => 'boolean',
        'achete' => 'boolean',
        'date_ajout' => 'date',
        'date_achat' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}