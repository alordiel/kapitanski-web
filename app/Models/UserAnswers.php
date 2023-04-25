<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAnswers extends Model
{
    use HasFactory;

    protected bool $timestamp = false;
    protected $fillable = ['exam_taking_id', 'question_id', 'answer_id', 'is_correct'];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
