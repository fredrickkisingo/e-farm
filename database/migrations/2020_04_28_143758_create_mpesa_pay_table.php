<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMpesaPayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mpesa_pay', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('MerchantRequestID');
            $table->string('CheckoutRequestID');
            $table->integer('ResultCode');
            $table->string('ResultDesc');
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
        Schema::dropIfExists('mpesa_pay');
    }
}
