<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsSpecsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_specs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shopId')->unsigned();
            $table->integer('goodsId')->unsigned();
            $table->string('no')->unqiue();
            $table->string('specIds', 128)->nullable();
            $table->decimal('marketPrice')->default(0.00);
            $table->decimal('specPrice')->default(0.00);
            $table->integer('specStock')->default(0);
            $table->integer('warnStock')->default(0);
            $table->integer('saleNum')->default(0);
            $table->boolean('isDefault')->default(false);
            $table->softDeletes();
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
        Schema::dropIfExists('goods_specs');
    }
}
