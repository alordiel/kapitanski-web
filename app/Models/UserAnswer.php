<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAnswer extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['user_id','exam_taking_id', 'question_id', 'answer_id', 'is_correct'];

    public function examTaking(): BelongsTo
    {
        return $this->belongsTo(ExamTaking::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function answer(): BelongsTo
    {
        return $this->belongsTo(Answer::class);
    }
}
