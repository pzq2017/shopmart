<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsCatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_cats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parentId')->unsigned()->default(0);
            $table->string('name', 64)->nullable();
            $table->boolean('isShow')->default(false);
            $table->boolean('isFloor')->default(false);
            $table->integer('sort')->default(0);
            $table->decimal('commissionRate')->default(0.00);
            $table->softDeletes();
            $table->timestamps();
            $table->index('parentId');
            $table->index(['isShow', 'isFloor']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods_cats');
    }
}
