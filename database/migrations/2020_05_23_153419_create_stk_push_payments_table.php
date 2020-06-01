<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStkPushPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stk_push_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('MpesaReceiptNumber')->default('0');
            $table->string('phonenumber');
            $table->integer('amount')->default(0);
            $table->string('ResultDesc');
            $table->string('CheckoutRequestID');
            $table->string('MerchantRequestID');
            $table->string('status');
           
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stk_push_payments');
    }
}
