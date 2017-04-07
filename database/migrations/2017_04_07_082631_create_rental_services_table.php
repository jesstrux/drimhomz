<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRentalServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_nearby_sevices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('distance')->nullable();
            $table->integer('rental_id')->unsigned();
            $table->integer('nearby_service_id')->unsigned();
            $table->foreign('rental_id')
                ->references('id')
                ->on('rentals')
                ->onDelete('cascade');
            $table->foreign('nearby_service_id')
                ->references('id')
                ->on('nearby_services')
                ->onDelete('cascade');
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
        Schema::dropIfExists('rental_nearby_sevices');
    }
}
