<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysMenusPrivilegesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_menus_privileges', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('menuId')->unsigned();
            $table->string('code', 32)->unique();
            $table->string('name', 64)->nullable();
            $table->boolean('isMenu')->default(false);
            $table->string('url')->nullable();
            $table->string('otherUrl')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index('menuId');
            $table->index('isMenu');
            $table->foreign('menuId')->references('id')->on('sys_menus');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_menus_privileges');
    }
}
