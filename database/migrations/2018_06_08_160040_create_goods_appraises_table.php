<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsAppraisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_appraises', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shopId')->unsigned();
            $table->integer('orderId')->unsigned();
            $table->integer('goodsId')->unsigned();
            $table->integer('goodsSpecId')->unsigned();
            $table->integer('memberId')->unsigned();
            $table->tinyInteger('goodsScore')->default(0);
            $table->tinyInteger('serviceScore')->default(0);
            $table->tinyInteger('timeScore')->default(0);
            $table->text('content')->nullable();
            $table->text('img')->nullable();
            $table->text('shopReply')->nullable();
            $table->boolean('isShow')->default(true);
            $table->timestamp('createTime')->nullable();
            $table->timestamp('replyTime')->nullable();
            $table->softDeletes();
            $table->index('shopId');
            $table->index('orderId');
            $table->index('goodsId');
            $table->index('goodsSpecId');
            $table->index('memberId');
            $table->foreign('memberId')->references('id')->on('members');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods_appraises');
    }
}
