<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('orderId')->unsigned();
            $table->integer('goodsId')->unsigned();
            $table->integer('quantity')->unsigned()->default(0);
            $table->decimal('price')->default(0.00);
            $table->integer('goodsSpecId')->unsigned()->default(0);
            $table->string('goodsSpecName')->nullable();
            $table->string('goodsName')->nullable();
            $table->string('goodsImg')->nullable();
            $table->decimal('commissionRate')->default(0.00);
            $table->timestamps();
            $table->index(['orderId', 'goodsId']);
            $table->foreign('orderId')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_details');
    }
}
