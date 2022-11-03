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
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('seller_id')->references('id')->on('users')->constrained()->restrictOnDelete();
            $table->foreignUuid('category_id')->references('id')->on('categories')->constrained()->restrictOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('desc');
            $table->string('artist')->nullable();
            $table->string('dimension');
            $table->bigInteger('price');
            $table->tinyInteger('discount')->nullable();
            $table->integer('quantity');
            $table->text('image');
            $table->string('tags')->nullable();
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
        Schema::dropIfExists('products');
    }
};
