<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'order_status', 'payment_id', 'payment_method', 'invoice_number'];

    public function user():belongsTo {
        return $this->belongsTo(User::class);
    }

    public function product():belongsTo {
        return $this->belongsTo(Product::class);
    }

    public function exam():belongsTo {
        return $this->belongsTo(Exam::class);
    }
}
