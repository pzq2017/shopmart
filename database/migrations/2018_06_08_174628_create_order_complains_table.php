<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderComplainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_complains', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('orderId')->unsigned();
            $table->tinyInteger('type')->default(0);
            $table->integer('targetId')->default(0);
            $table->text('complainContent')->nullable();
            $table->string('complainAnnex')->nullable();
            $table->tinyInteger('complainStatus')->default(0);
            $table->timestamp('complainTime')->nullable();
            $table->boolean('needRespond')->default(true);
            $table->integer('respondTargetId')->unsigned();
            $table->text('respondContent')->nullable();
            $table->string('respondAnnex')->nullable();
            $table->timestamp('respondTime')->nullable();
            $table->string('finalResult')->nullable();
            $table->timestamp('finalTime')->nullable();
            $table->integer('finalHandleStaffId')->default(0);
            $table->timestamps();
            $table->index(['orderId', 'type']);
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
        Schema::dropIfExists('order_complains');
    }
}
