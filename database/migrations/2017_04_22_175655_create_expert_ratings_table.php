<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpertRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expert_ratings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('expert_id')->unsigned();
            $table->integer('rating_id')->unsigned();
            $table->timestamps();
            $table->foreign('expert_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('rating_id')
                ->references('id')
                ->on('ratings')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expert_ratings');
    }
}
