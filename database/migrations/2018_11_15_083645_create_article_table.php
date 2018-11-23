<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('catid')->default(0);
            $table->string('title', 128)->nullable();
            $table->longText('text')->nullable();
            $table->string('image_path', 108)->nullable();
            $table->string('desc', 256)->nullable();
            $table->string('author', 32)->nullable();
            $table->unsignedInteger('view_count')->default(0);
            $table->dateTime('pub_date')->nullable();
            $table->integer('sort')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article');
    }
}
