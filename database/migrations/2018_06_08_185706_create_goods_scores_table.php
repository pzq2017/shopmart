<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_scores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shopId')->unsigned();
            $table->integer('goodsId')->unsigned();
            $table->integer('totalScore')->default(0);
            $table->integer('totalUsers')->default(0);
            $table->integer('goodsScore')->default(0);
            $table->integer('goodsUsers')->default(0);
            $table->integer('serviceScore')->default(0);
            $table->integer('serviceUsers')->default(0);
            $table->integer('timeScore')->default(0);
            $table->integer('timeUsers')->default(0);
            $table->timestamps();
            $table->index(['shopId', 'goodsId']);
            $table->foreign('goodsId')->references('id')->on('goods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods_scores');
    }
}
