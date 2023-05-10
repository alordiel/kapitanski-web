<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exam extends Model
{
    use HasFactory;

    protected bool $timestamp = false;
    protected $fillable = ['name'];

    public function examTaking(): hasMany
    {
        return $this->hasMany(ExamTaking::class);
    }

    public function subscription(): hasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function question(): hasMany
    {
        return $this->hasMany(Question::class);
    }
}
