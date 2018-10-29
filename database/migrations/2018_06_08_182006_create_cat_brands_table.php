<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_brands', function (Blueprint $table) {
            $table->integer('goodsCatId')->unsigned();
            $table->integer('brandId')->unsigned();
            $table->index(['goodsCatId', 'brandId']);
            $table->foreign('goodsCatId')->references('id')->on('goods');
            $table->foreign('brandId')->references('id')->on('brands');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cat_brands');
    }
}
