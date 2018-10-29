<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopCatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_cats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shopId')->unsigned();
            $table->integer('parentId')->unsigned()->default(0);
            $table->boolean('isShow')->default(false);
            $table->string('name', 64)->nullable();
            $table->integer('sort')->default(0);
            $table->softDeletes();
            $table->timestamps();
            $table->index(['shopId', 'parentId']);
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
        Schema::dropIfExists('shop_cats');
    }
}
