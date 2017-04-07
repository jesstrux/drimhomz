<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlotImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plot_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image_url');
            $table->string('placeholder_color');
            $table->string('caption')->nullable();
            $table->integer('plot_id')->unsigned();
            $table->foreign('plot_id')
                ->references('id')
                ->on('plots')
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
        Schema::dropIfExists('plot_images');
    }
}
