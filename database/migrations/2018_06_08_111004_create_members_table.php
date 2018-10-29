<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('loginName', 64)->unique();
            $table->string('loginSecret', 32)->unique();
            $table->string('loginPwd', 64);
            $table->tinyInteger('type')->default(0);
            $table->tinyInteger('sex')->default(0);
            $table->string('userName', 64)->nullable();
            $table->string('realName', 64)->nullable();
            $table->string('birthday', 20)->nullable();
            $table->string('headimage')->nullable();
            $table->string('qq', 16)->nullable();
            $table->string('phone', 32)->nullable();
            $table->string('email', 64);
            $table->integer('score')->unsigned()->default(0);
            $table->integer('totalScore')->unsigned()->default(0);
            $table->ipAddress('lastIp')->nullable();
            $table->timestamp('lastTime');
            $table->tinyInteger('source')->default(0);
            $table->decimal('money')->default('0.00');
            $table->decimal('lockMoney')->default('0.00');
            $table->tinyInteger('status')->default(0);
            $table->string('payPwd', 64)->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->index(['phone', 'email']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
