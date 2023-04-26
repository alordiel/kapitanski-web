<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAnswer extends Model
{
    use HasFactory;

    protected bool $timestamp = false;
    protected $fillable = ['exam_taking_id', 'question_id', 'answer_id', 'is_correct'];

    public function examTaking():belongsTo {
        return $this->belongsTo(ExamTaking::class);
    }

    public function question():belongsTo {
        return $this->belongsTo(Question::class);
    }

    public function answer():belongsTo {
        return $this->belongsTo(Answer::class);
    }
}
