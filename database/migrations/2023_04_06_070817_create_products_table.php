<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         *   product_name varchar
  product_order integer
  description text
  credits integer
  price float
         */
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('product_name')->unique();
            $table->float('price');
            $table->integer('product_order');
            $table->text('description');
            $table->integer('number_of_credits');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
};
