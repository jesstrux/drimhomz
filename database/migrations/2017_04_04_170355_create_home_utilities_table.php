<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomeUtilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_utilities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('count')->default(1);
            $table->integer('home_id')->unsigned();
            $table->integer('utility_id')->unsigned();
            $table->foreign('home_id')
                ->references('id')
                ->on('homes')
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
        Schema::dropIfExists('home_utilities');
    }
}
