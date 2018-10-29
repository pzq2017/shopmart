<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sNo', 32)->unique();
            $table->string('name')->nullable();
            $table->string('img')->nullable();
            $table->integer('shopId')->unsigned()->default(0);
            $table->decimal('marketPrice')->default(0.00);
            $table->decimal('shopPrice')->default(0.00);
            $table->integer('warnStock')->default(0);
            $table->integer('stock')->default(0);
            $table->char('unit', 8)->nullable();
            $table->string('tips', 512);
            $table->boolean('isSale')->default(false);
            $table->boolean('isBest')->default(false);
            $table->boolean('isHot')->default(false);
            $table->boolean('isNew')->default(false);
            $table->boolean('isRecom')->default(false);
            $table->string('goodsCatId')->nullable();
            $table->string('shopCatId')->nullable();
            $table->integer('brandId')->default(0);
            $table->mediumText('desc')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->integer('saleNum')->default(0);
            $table->integer('visitNum')->default(0);
            $table->integer('appraiseNum')->default(0);
            $table->string('seoKeywords')->nullable();
            $table->boolean('isSpec')->default(false);
            $table->text('gallery')->nullable();
            $table->text('illegalRemarks')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->index('name');
            $table->index('shopId');
            $table->index(['isSale', 'isNew', 'isBest', 'isRecom', 'isHot']);
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
        Schema::dropIfExists('goods');
    }
}
