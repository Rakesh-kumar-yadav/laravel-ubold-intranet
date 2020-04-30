<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDownhistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('downhistories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_name');
            $table->string('file_name');
            $table->string('docu_name');
            $table->string('revision_no');
            $table->string('category_name');
            $table->string('company_name');
            $table->string('depart_name');
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
        Schema::dropIfExists('downhistory');
    }
}
