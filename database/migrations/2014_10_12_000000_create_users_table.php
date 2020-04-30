<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('fullname')->nullable();
            $table->string('email');
            $table->date('birth')->nullable();
            $table->string('title')->nullable();
            $table->string('rank')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('extension_number')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('password');
            $table->string('photo')->default('assets/images/users/avatar.png');
            $table->string('remember_token')->nullable();

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
        Schema::dropIfExists('users');
    }
}
