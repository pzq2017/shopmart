<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('platform')->default(0);
            $table->integer('positionId')->unsigned();
            $table->string('path');
            $table->string('name')->nullable();
            $table->string('link')->nullable();
            $table->dateTime('startDate')->nullable();
            $table->dateTime('endDate')->nullable();
            $table->integer('sort')->default(0);
            $table->integer('click_num')->default(0);
            $table->softDeletes();
            $table->timestamps();
            $table->index(['platform', 'positionId']);
            $table->foreign('positionId')->references('id')->on('ad_positions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ads');
    }
}
