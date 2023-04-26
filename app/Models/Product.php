<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    public $table = "products";
    public $timestamps = false;
    protected $fillable = ['product_name', 'price', 'product_order', 'description', 'number_of_credits'];

    protected function order(): hasMany
    {
        return $this->hasMany(Order::class);
    }
}
