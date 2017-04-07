<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fname');
            $table->string('lname');
            $table->string('phone')->unique();
            $table->string('password');
            $table->string('town')->nullable();
            $table->string('gender')->nullable();
            $table->string('skills')->nullable();
            $table->string('description')->nullable();
            $table->datetime('dob')->nullable();
            $table->string('verification_code')->nullable();
            $table->char('verified')->default('0')->comment = "verified=0 when the phone number is not verified yet, verified=1 for a verified phone number";
            $table->string('dp')->default("drimhomzDefaultDp.png");
            $table->string('role')->default('user');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
