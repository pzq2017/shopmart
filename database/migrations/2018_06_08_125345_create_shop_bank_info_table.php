<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopBankInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_bank_info', function (Blueprint $table) {
            $table->integer('shopId')->unique()->unsigned();
            $table->tinyInteger('bankId')->unsigned()->default(0);
            $table->string('bankNo', 32)->nullable();
            $table->string('bankUserName', 64)->nullable();
            $table->integer('province')->unsigend()->default(0);
            $table->integer('city')->unsigend()->default(0);
            $table->integer('area')->unsigend()->default(0);
            $table->timestamps();
            $table->index('bankId');
            $table->foreign('shopId')->references('id')->on('shops');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_bank_info');
    }
}
