<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TypeProjet extends Model
{
    protected $table = 'types_projets';

    protected $fillable = [
        'user_id',
        'nom',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}