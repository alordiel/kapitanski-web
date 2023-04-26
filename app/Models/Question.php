<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    protected bool $timestamp = false;
    protected $fillable = ['question', 'answer_id', 'correct_answer', 'category_id', 'type'];

    public function questionCategory():hasMany {
        return $this->hasMany(questionCategory::class);
    }
    public function userAnswer(): hasMany
    {
        return $this->hasMany(UserAnswer::class);
    }

    public function answer(): hasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function correctAnswer(): hasMany
    {
        return $this->hasMany(Answer::class);
    }
}
