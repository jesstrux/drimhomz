<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRentalUtilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_utilities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('count')->default(1);
            $table->integer('rental_id')->unsigned();
            $table->integer('utility_id')->unsigned();
            $table->foreign('rental_id')
                ->references('id')
                ->on('rentals')
                ->onDelete('cascade');
            $table->foreign('utility_id')
                ->references('id')
                ->on('utilities')
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
        Schema::dropIfExists('rental_utilities');
    }
}
