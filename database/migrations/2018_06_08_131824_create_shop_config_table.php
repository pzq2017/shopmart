<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_config', function (Blueprint $table) {
            $table->integer('shopId')->unsigned()->unqiue();
            $table->string('keywords')->nullable();
            $table->string('desc')->nullable();
            $table->string('hotWords')->nullable();
            $table->string('banner')->nullable();
            $table->text('ads')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('shop_config');
    }
}
