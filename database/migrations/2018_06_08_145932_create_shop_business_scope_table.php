<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopBusinessScopeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_scope', function (Blueprint $table) {
            $table->integer('shopId')->unsigned();
            $table->integer('catId')->unsigned();
            $table->index(['shopId', 'catId']);
            $table->foreign('shopId')->references('id')->on('shops');
            $table->foreign('catId')->references('id')->on('goods_cats');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('business_scope');
    }
}
