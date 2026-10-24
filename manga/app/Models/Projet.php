<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Projet extends Model
{
    protected $fillable = [
        'user_id',
        'nom',
        'description',
        'budget',
        'date_debut',
        'date_fin',
    ];

    protected $casts = [
        'budget' => 'decimal:2',
        'date_debut' => 'date',
        'date_fin' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function possibilites(): HasMany
    {
        return $this->hasMany(PossibiliteProjet::class);
    }
}