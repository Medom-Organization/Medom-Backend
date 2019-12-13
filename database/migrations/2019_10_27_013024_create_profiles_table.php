<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->string('id');
            $table->primary('id');
            $table->string('user_id');
            $table->string('bookings')->nullable();
            $table->string('genotype')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('wallet');
            $table->string('allergies')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('religion')->nullable();
            $table->string('next of kin')->nullable();
            $table->string('address')->nullable();
            $table->string('DOB')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('phone_no')->nullable();

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
        Schema::dropIfExists('profiles');
    }
}
