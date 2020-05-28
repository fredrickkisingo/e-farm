<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStkPushesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stk_pushes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('MpesaReceiptNumber');
            $table->string('phonenumber');
            $table->string('ResultCode');
            $table->integer('amount')->default(0);
            $table->string('ResultDesc');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stk_pushes');
    }
}
