<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHospitalprofileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospitalprofile', function (Blueprint $table) {
            $table->string('id');
            $table->primary('id');
            $table->string('hospital_name');
            $table->string('address');
            $table->string('phone_no');
            $table->string('national_id');
            $table->string('logo');
            $table->string('user_id');
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
        Schema::dropIfExists('hospitalprofile');
    }
}
