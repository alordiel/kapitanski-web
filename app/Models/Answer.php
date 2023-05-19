<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Answer extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['answer'];

    public function userAnswer(): hasMany
    {
        return $this->hasMany(UserAnswer::class);
    }

    public function question(): belongsTo
    {
        return $this->belongsTo(Question::class);
    }

}
