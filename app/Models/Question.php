<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
