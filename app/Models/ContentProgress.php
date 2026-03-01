<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentProgress extends Model
{
    protected $fillable = [
        'content_id',
        'user_id',
        'completed',
        'xp_awarded',
        'payload',
    ];

    protected $casts = [
        'completed' => 'boolean',
        'payload' => 'array',
    ];
}
