<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('catId')->unsigned();
            $table->string('title')->nullable();
            $table->boolean('isShow')->default(false);
            $table->mediumText('content')->nullable();
            $table->string('keyword', 64)->nullable();
            $table->integer('staffId')->unsigned()->default(0);
            $table->integer('readCount')->unsigned()->default(0);
            $table->softDeletes();
            $table->timestamps();
            $table->index(['catId', 'isShow', 'keyword', 'staffId']);
            $table->foreign('catId')->references('id')->on('article_cats');
            $table->foreign('staffId')->references('id')->on('staffs');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
