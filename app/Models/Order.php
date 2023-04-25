<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'order_status', 'exam_id', 'payment_id', 'payment_method', 'invoice_number'];
}
