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
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('buyer_id')->references('id')->on('users')->constrained()->restrictOnDelete();
            $table->foreignUuid('product_id')->references('id')->on('products')->constrained()->restrictOnDelete();
            $table->string('order_number');
            $table->timestamp('delivery_date');
            $table->enum('delivery_status', ['restitute', 'canceled', 'continue', 'complete']);
            $table->enum('payment', ['bank', 'credit', 'paypal']);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
