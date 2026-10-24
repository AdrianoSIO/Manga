<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BudgetPossibilite extends Model
{
    protected $table = 'vue_budget_possibilites';

    public $timestamps = false;

    protected $primaryKey = 'possibilite_id';

    public $incrementing = false;

    protected $casts = [
        'projet_id' => 'integer',
        'possibilite_id' => 'integer',
        'user_id' => 'integer',
        'budget' => 'decimal:2',
        'total_depenses' => 'decimal:2',
        'reste' => 'decimal:2',
        'pourcentage_budget' => 'decimal:1',
        'hors_budget' => 'boolean',
    ];

    public function projet(): BelongsTo
    {
        return $this->belongsTo(
            Projet::class,
            'projet_id'
        );
    }

    public function possibilite(): BelongsTo
    {
        return $this->belongsTo(
            PossibiliteProjet::class,
            'possibilite_id'
        );
    }
}