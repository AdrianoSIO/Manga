<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PossibiliteProjet extends Model
{
    protected $fillable = [
        'projet_id',
        'nom',
        'description',
        'statut',
    ];

    public function projet(): BelongsTo
    {
        return $this->belongsTo(Projet::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(CategorieProjet::class);
    }

    use Illuminate\Database\Eloquent\Relations\HasOne;

// ...

    public function budget(): HasOne
    {
    return $this->hasOne(
        BudgetPossibilite::class,
        'possibilite_id',
        'id'
    );
    }
}