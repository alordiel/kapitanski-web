<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuestionCategory extends Model
{
    use HasFactory;
    protected bool $timestamp = false;
    protected $fillable = ['name', 'slug'];

    public function question():belongsTo{
        return $this->belongsTo(Question::class);
    }
}
