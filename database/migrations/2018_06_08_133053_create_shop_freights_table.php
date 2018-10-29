<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopFreightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_freights', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shopId')->unsigned()->default(0);
            $table->integer('area')->unsigned()->default(0);
            $table->tinyInteger('freight')->default(0);
            $table->timestamps();
            $table->index('shopId');
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
        Schema::dropIfExists('shop_freights');
    }
}
