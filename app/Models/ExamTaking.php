<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamTaking extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'exam_id', 'exam_type', 'result'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    public function userAnswers():HasMany {
        return $this->hasMany(UserAnswer::class);
    }
}
