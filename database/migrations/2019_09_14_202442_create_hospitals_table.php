<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHospitalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospitals', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('id');
            $table->primary('id');
            $table->string('hospital_name');
            $table->string('email');
            $table->string('address');
            $table->string('phone_no');
            $table->string('certificate_no');
            $table->string('logo');
            $table->string('user_id');
            $table->timestamps();
        });
        Schema::table('hospitals', function ($table) {
            $table->engine = 'InnoDB';
            $table->foreign('user_id')->references('uid')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hospitals');
    }
}
