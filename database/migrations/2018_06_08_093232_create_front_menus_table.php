<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrontMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('front_menus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parentId')->unsigned();
            $table->string('name')->nullable();
            $table->string('url')->nullable();
            $table->string('otherUrl')->nullable();
            $table->tinyInteger('type')->default(0);
            $table->boolean('isShow')->default(false);
            $table->integer('sort')->default(0);
            $table->softDeletes();
            $table->timestamps();
            $table->index('parentId');
            $table->index(['type', 'isShow']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('front_menus');
    }
}
