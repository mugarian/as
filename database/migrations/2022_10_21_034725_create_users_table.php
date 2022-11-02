<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Ramsey\Uuid\Uuid;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('phone_number', 15)->unique();
            $table->text('address');
            $table->string('username', 15)->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('image')->nullable();
            $table->enum('role', ['buyer', 'seller', 'admin']);
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
        Schema::dropIfExists('users');
    }
};
