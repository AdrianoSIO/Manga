<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ElementProjet extends Model
{
    protected $fillable = [
        'categorie_projet_id',
        'nom',
        'description',
        'prix',
        'quantite',
        'url',
        'selectionne',
    ];

    protected $casts = [
        'prix' => 'decimal:2',
        'quantite' => 'integer',
        'selectionne' => 'boolean',
    ];

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(
            CategorieProjet::class,
            'categorie_projet_id'
        );
    }
}