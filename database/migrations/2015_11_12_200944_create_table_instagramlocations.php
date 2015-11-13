<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableInstagramlocations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instagramlocations', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->float('latitude',10,6);
            $table->float('longitude',10,6);
            $table->string('name', 500);
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
        Schema::drop('instagramlocations');
    }
}
