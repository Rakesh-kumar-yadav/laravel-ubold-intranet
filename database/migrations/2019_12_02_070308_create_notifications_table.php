<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->integer('depart_id')->nullable();
            $table->integer('docu_id')->default(0);
            $table->integer('revision_id')->nullable();
            $table->string('docu_name')->nullable();
            $table->integer('embed_id')->default(0);
            $table->string('created_user_id')->nullable();
            $table->integer('confirm')->default(0);
            $table->datetime('due_date')->default("9999-12-31 00:00:00");
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
        Schema::dropIfExists('notifications');
    }
}
