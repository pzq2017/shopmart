<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberAccountSecurityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_account_security', function (Blueprint $table) {
            $table->unsignedInteger('memberId')->default(0);
            $table->unsignedTinyInteger('type')->default(0);
            $table->string('flag', 32)->nullable();
            $table->boolean('status')->default(false);
            $table->dateTime('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_account_security');
    }
}
