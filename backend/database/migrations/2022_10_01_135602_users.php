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
            $table->integer("liker");
            $table->integer("liked");
            $table->timestamps();
        });

        Schema::create('blocks', function (Blueprint $table) {
            $table->integer("blocker");
            $table->integer("blocked");
            $table->timestamps();
        });

        Schema::create('favorites', function (Blueprint $table) {
            $table->integer("favoriter");
            $table->integer("favorited");
            $table->timestamps();
        });

        Schema::create('chats', function (Blueprint $table) {
            $table->integer("user1");
            $table->integer("user2");
            $table->timestamps();
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->integer("chat_id");
            $table->integer("sender_id");
            $table->integer("contents");
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
