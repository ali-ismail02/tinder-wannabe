<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        Schema::create('likes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("liker")->unsigned();
            $table->integer("liked")->unsigned();
            $table->foreign('liker')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('liked')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('blocks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("blocker")->unsigned();
            $table->integer("blocked")->unsigned();
            $table->foreign('blocker')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('blocked')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('favorites', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("favoriter")->unsigned();
            $table->integer("favorited")->unsigned();
            $table->foreign('favoriter')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('favorited')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('chats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("user1")->unsigned();
            $table->integer("user2")->unsigned();
            $table->foreign('user1')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user2')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("chat_id")->unsigned();
            $table->integer("sender_id")->unsigned();
            $table->string("contents");
            $table->foreign('chat_id')->references('id')->on('chats')->onDelete('cascade');
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('likes');
        Schema::dropIfExists('blocks');
        Schema::dropIfExists('favorites');
        Schema::dropIfExists('chats');
        Schema::dropIfExists('messages');
        Schema::dropIfExists('messages');
    }
};
