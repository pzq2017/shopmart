<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberGradeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_grade', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 32)->nullable();
            $table->string('icon', 108)->nullable();
            $table->unsignedInteger('min_score')->default(0);
            $table->unsignedInteger('max_score')->nullable(0);
            $table->decimal('rebate', 8, 1)->default(0.0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_grade');
    }
}
