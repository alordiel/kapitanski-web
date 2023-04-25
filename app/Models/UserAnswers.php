<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswers extends Model
{
    use HasFactory;

    protected bool $timestamp = false;
    protected $fillable = ['exam_taking_id', 'question_id', 'answer_id', 'is_correct'];
}
