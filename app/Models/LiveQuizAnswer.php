<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveQuizAnswer extends Model
{
    protected $table = 'live_quiz_answers';

    protected $fillable = [
        'session_id',
        'user_id',
        'question_index',
        'choice',
        'is_correct',
        'response_ms',
        'answered_at_ms',
    ];

    protected function casts(): array
    {
        return [
            'is_correct' => 'boolean',
        ];
    }
}
