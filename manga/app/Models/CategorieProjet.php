<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategorieProjet extends Model
{
    protected $fillable = [
        'possibilite_projet_id',
        'nom',
    ];

    public function possibilite(): BelongsTo
    {
        return $this->belongsTo(
            PossibiliteProjet::class,
            'possibilite_projet_id'
        );
    }

    public function elements(): HasMany
    {
        return $this->hasMany(ElementProjet::class);
    }
}