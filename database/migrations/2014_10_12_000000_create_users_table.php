<?php

use Illuminate\Support\Facades\Schema;
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
            $table->engine = 'InnoDB';
            $table->string('id');
            $table->primary('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('role_id');
            $table->string('password');
            $table->string('phone_number')->nullable();
            $table->string('role');
            $table->string('profile_picture')->nullable();
            $table->timestamps();
        });
        Schema::table('users', function ($table) {
            $table->engine = 'InnoDB';
            $table->foreign('role_id')->references('_id')->on('roles')->onDelete('cascade');
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
