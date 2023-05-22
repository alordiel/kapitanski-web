<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exam extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];

    public function examTakings(): HasMany
    {
        return $this->hasMany(ExamTaking::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
}
