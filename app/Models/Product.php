<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
      use HasFactory;

    public $timestamps = false;
    protected $fillable = ['name', 'price', 'description', 'credits'];

    protected function order(): hasMany
    {
        return $this->hasMany(Order::class);
    }
}
