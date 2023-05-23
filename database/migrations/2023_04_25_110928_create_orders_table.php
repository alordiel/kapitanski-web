<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('orders', static function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('credits');
            $table->integer('single_price');
            $table->integer('total');
            $table->string('order_status');
            $table->integer('payment_id');
            $table->string('payment_method');
            $table->string('invoice_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
