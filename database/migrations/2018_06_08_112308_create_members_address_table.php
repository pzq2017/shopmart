<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members_address', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('memberId')->unsigned();
            $table->string('name');
            $table->string('phone');
            $table->smallInteger('province');
            $table->smallInteger('city');
            $table->smallInteger('area');
            $table->string('address');
            $table->boolean('isDefault')->default(false);
            $table->softDeletes();
            $table->timestamps();
            $table->index('memberId');
            $table->index('isDefault');
            $table->foreign('memberId')->references('id')->on('members');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members_address');
    }
}
