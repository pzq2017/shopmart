<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staffs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('loginName', 64)->unique();
            $table->string('password', 64);
            $table->string('secretKey', 128)->unique();
            $table->string('staffName', 64)->nullable();
            $table->string('staffNo', 64)->unique();
            $table->string('staffPhoto', 128)->nullable();
            $table->integer('staffRoleId')->default(0);
            $table->boolean('workStatus')->default(true);
            $table->boolean('staffStatus')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->timestamp('lastTime')->nullable();
            $table->ipAddress('lastIp')->nullable();
            $table->rememberToken();
            $table->index(['workStatus', 'staffStatus']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staffs');
    }
}
