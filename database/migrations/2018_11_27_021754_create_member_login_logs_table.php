<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberLoginLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_login_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('memberId')->default(0);
            $table->string('loginIp', 16)->nullable();
            $table->string('loginDevice', 32)->nullable();
            $table->dateTime('loginDate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_login_logs');
    }
}
