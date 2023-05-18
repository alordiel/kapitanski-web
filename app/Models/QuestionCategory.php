<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuestionCategory extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['name', 'slug'];

    public function question():hasMany{
        return $this->hasMany(Question::class);
    }
}
