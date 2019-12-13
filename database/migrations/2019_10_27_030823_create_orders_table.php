<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->string('id');
            $table->primary('id');
            $table->string('booking_id');
            $table->string('first_name');
            $table->string('surname');
            $table->string('email');
            $table->string('phone');
            $table->string('amount');
            $table->string('currency');
            $table->string('price_info');
            $table->string('booking_type');
            $table->string('status');
            $table->string('description');
            $table->string('user_id');
            $table->string('hospital_id');
            $table->string('date');
            $table->string('time');
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
        Schema::dropIfExists('orders');
    }
}
