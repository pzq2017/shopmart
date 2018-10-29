<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageReceiversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_receivers', function (Blueprint $table) {
            $table->integer('messageId')->unsigned();
            $table->integer('receiverId')->unsigned();
            $table->boolean('isRead')->default(false);
            $table->timestamp('sendTime');
            $table->index('messageId');
            $table->index('receiverId');
            $table->index('isRead');
            $table->foreign('messageId')->references('id')->on('messages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('message_receivers');
    }
}
