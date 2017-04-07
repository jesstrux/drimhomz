<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomeServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_nearby_sevices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('distance')->nullable();
            $table->integer('home_id')->unsigned();
            $table->integer('nearby_service_id')->unsigned();
            $table->foreign('home_id')
                ->references('id')
                ->on('homes')
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
        Schema::dropIfExists('home_nearby_sevices');
    }
}
