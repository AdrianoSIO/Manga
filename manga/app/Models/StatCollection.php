<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatCollection extends Model
{
    protected $table = 'vue_stats_collection';

    public $timestamps = false;

    protected $primaryKey = 'user_id';

    public $incrementing = false;

    protected $casts = [
        'user_id' => 'integer',
        'total_licences' => 'integer',
        'total_exemplaires' => 'integer',
    ];
}