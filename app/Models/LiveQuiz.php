<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveQuiz extends Model
{
    protected $table = 'live_quizzes';

    protected $fillable = [
        'teacher_id',
        'title',
        'target_class',
        'target_section',
        'status',
        'payload',
    ];

    protected function casts(): array
    {
        return [
            'payload' => 'array',
        ];
    }
}
