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
        Schema::create('selfservice_requests', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('phone')->nullable();
            $table->string('code')->nullable();
            $table->string('sms_api_response')->nullable();
            $table->dateTime('expiration_code')->nullable();
            $table->boolean('code_result')->default(false);
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('selfservice_requests');
    }
};
