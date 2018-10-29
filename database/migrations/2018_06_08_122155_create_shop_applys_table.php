<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopApplysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_applys', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('memberId')->unsigned()->default(0);
            $table->string('applicant', 64)->nullable();
            $table->string('phoneNo', 20)->nullable();
            $table->string('applyDesc')->nullable();
            $table->tinyInteger('applyStatus')->default(0);
            $table->string('handleDesc')->nullable();
            $table->integer('shopId')->unsigned()->default(0);
            $table->softDeletes();
            $table->timestamps();
            $table->index(['memberId', 'shopId']);
            $table->foreign('memberId')->references('id')->on('members');
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
        Schema::dropIfExists('shop_applys');
    }
}
