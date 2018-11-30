<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member', function (Blueprint $table) {
            $table->increments('id');
            $table->string('loginAccount', 32)->nullable();
            $table->string('loginPwd', 64)->nullable();
            $table->unsignedTinyInteger('type')->default(0);
            $table->unsignedTinyInteger('grade')->default(0);
            $table->string('nickname', 64)->nullable();
            $table->string('avatar', 108)->nullable();
            $table->string('realname', 64)->nullable();
            $table->unsignedTinyInteger('sex')->default(0);
            $table->string('birthday', 16)->nullable();
            $table->string('mobile', 16)->nullable();
            $table->string('email', 32)->nullable();
            $table->string('qq', 16)->nullable();
            $table->unsignedTinyInteger('balance_score')->default(0);
            $table->unsignedInteger('totalScore')->default(0);
            $table->unsignedTinyInteger('status')->default(0);
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
        Schema::dropIfExists('member');
    }
}
