<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableInstagramusers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instagramusers', function (Blueprint $table) {
            $table->string('id',50)->primary();
            $table->string('username', 255)->unique();
            $table->string('full_name', 255);
            $table->string('profile_picture', 500);
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
        Schema::drop('instagramusers');
    }
}
