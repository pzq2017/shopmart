<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sNo', 32)->unique();
            $table->integer('memberId')->unsigned()->default(0);
            $table->string('shopName', 128)->nullable();
            $table->string('keeper', 64)->nullable();
            $table->string('telphone', 32)->nullable();
            $table->string('shopCompany')->nullable();
            $table->string('shopImg')->nullable();
            $table->string('shopTel', 32)->nullable();
            $table->string('shopQQ', 12)->nullable();
            $table->string('shopAliWangWang', 32)->nullable();
            $table->boolean('isSelf')->default(false);
            $table->string('accred_types', 128)->nullable();
            $table->integer('province')->unsigned()->default(0);
            $table->integer('city')->unsigned()->default(0);
            $table->integer('area')->unsigned()->default(0);
            $table->string('shopAddress')->nullable();
            $table->boolean('isInvoice')->default(false);
            $table->string('invoiceRemarks')->nullable();
            $table->time('serviceStartTime');
            $table->time('serviceEndTime');
            $table->tinyInteger('default_freight')->default(0);
            $table->boolean('businessStatus')->default(false);
            $table->boolean('shopStatus')->default(false);
            $table->string('statusReason')->nullable();
            $table->decimal('shopBalance')->default(0.00);
            $table->decimal('forzenMoney')->default(0.00);
            $table->integer('noSettledOrderNum')->default(0);
            $table->decimal('noSettledOrderFee')->default(0.00);
            $table->decimal('paymentMoney')->default(0.00);
            $table->softDeletes();
            $table->timestamps();
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
        Schema::dropIfExists('shops');
    }
}
