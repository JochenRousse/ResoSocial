<?php

use Illuminate\Support\Facades\Schema;
use Jenssegers\Mongodb\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFriendRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friends_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_demandé')->index();
            $table->foreign('id_demandé')->references('id')->on('users')->onDelete('cascade');
            $table->string('id_demandeur')->index();
            $table->boolean('accepté');
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
        Schema::dropIfExists('friends_requests');
    }
}
