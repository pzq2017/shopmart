<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleCatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_cats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parentId')->unsigned()->default(0);
            $table->tinyInteger('type')->default(0);
            $table->boolean('isShow')->default(false);
            $table->string('name', 64)->nullable();
            $table->integer('sort')->default(0);
            $table->softDeletes();
            $table->timestamps();
            $table->index(['parentId', 'type', 'isShow']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_cats');
    }
}
