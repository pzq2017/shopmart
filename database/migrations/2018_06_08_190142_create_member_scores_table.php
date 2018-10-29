<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_scores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('memberId')->unsigned();
            $table->tinyInteger('type')->default(0);
            $table->integer('score')->default(0);
            $table->tinyInteger('dataFrom')->default(0);    //数据来源
            $table->integer('dataId')->default(0);
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->index('memberId');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_scores');
    }
}
