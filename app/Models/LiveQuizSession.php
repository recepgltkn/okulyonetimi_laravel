<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveQuizSession extends Model
{
    protected $table = 'live_quiz_sessions';

    protected $fillable = [
        'live_quiz_id',
        'teacher_id',
        'quiz_title',
        'status',
        'current_index',
        'target_class',
        'target_section',
        'payload',
    ];

    protected function casts(): array
    {
        return [
            'payload' => 'array',
        ];
    }
}
