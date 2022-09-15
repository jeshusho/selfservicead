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
        Schema::create('adusers', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('display_name')->nullable();
            $table->string('given_name')->nullable();
            $table->string('mail')->nullable();
            $table->string('department')->nullable();
            $table->boolean('password_expired')->default(false);
            $table->dateTime('expiration_date')->nullable();
            $table->string('expiration_str')->nullable();
            $table->integer('expiration_days')->nullable();
            $table->dateTime('last_notification')->nullable();
            $table->boolean('active')->default(false);
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
        Schema::dropIfExists('adusers');
    }
};
