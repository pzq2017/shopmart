<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsSpecCatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_spec_cats', function (Blueprint $table) {
            $table->increments('id');
            $table->string('goodsCatIds', 64)->nullable();
            $table->string('name', 64)->nullable();
            $table->boolean('isAllowImg')->default(false);
            $table->boolean('isShow')->default(false);
            $table->integer('sort')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods_spec_cats');
    }
}
