<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderRefundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_refunds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('orderId')->unsigned();
            $table->string('refundNo', 32)->unique();
            $table->text('refundReason')->nullable();
            $table->decimal('backMoney')->default(0.00);
            $table->text('refundRemark')->nullable();
            $table->timestamp('refundTime');
            $table->text('shopRejectReason')->nullable();
            $table->tinyInteger('refundStatus')->default(0);
            $table->timestamps();
            $table->index('orderId');
            $table->index('refundStatus');
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
        Schema::dropIfExists('order_refunds');
    }
}
