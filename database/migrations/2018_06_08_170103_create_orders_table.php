<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('orderno', 32)->unique();
            $table->string('batchNo', 32);
            $table->integer('shopId')->unsigned();
            $table->integer('memberId')->unsigned();
            $table->tinyInteger('status')->default(0);
            $table->decimal('goodsMoney')->default(0.00);
            $table->tinyInteger('deliverType')->default(0);
            $table->decimal('freight')->default(0.00);
            $table->decimal('totalMoney')->default(0.00);
            $table->decimal('realMoney')->default(0.00);
            $table->tinyInteger('payType')->default(0);
            $table->tinyInteger('payFrom')->default(0);
            $table->boolean('isPay')->default(false);
            $table->integer('province')->unsigned();
            $table->integer('city')->unsigned();
            $table->integer('area')->unsigned();
            $table->string('address')->nullable();
            $table->string('receiver', 64)->nullable();
            $table->string('receivcr_phone', 32)->nullable();
            $table->integer('orderScore')->default(0);
            $table->boolean('isInvoice')->default(false);
            $table->string('invoiceTitle')->nullable();
            $table->text('remarks')->nullable();
            $table->tinyInteger('orderSource')->default(0);
            $table->boolean('isRefund')->default(false);
            $table->boolean('isAppraise')->default(false);
            $table->boolean('isClosed')->default(false);
            $table->string('cancleReason', 512)->nullable();
            $table->string('rejectReason', 512)->nullable();
            $table->timestamp('receiveTime')->nullable();
            $table->timestamp('deliveryTime')->nullable();
            $table->integer('expressId')->default(0);
            $table->string('expressNo', 32)->nullable();
            $table->decimal('commissionFee')->default(0.00);
            $table->softDeletes();
            $table->timestamps();
            $table->index('batchNo');
            $table->index(['shopId', 'memberId']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
