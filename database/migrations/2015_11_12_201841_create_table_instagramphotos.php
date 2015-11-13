<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableInstagramphotos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instagramphotos', function (Blueprint $table) {
            $table->string('id',50)->primary();
            $table->text('text');
            $table->string('online_location', 255);
            $table->string('local_location', 255);
            $table->string('instagram_link', 255);
            $table->dateTime('instagram_create_date');
            $table->string('instagramusers_id', 50);
            $table->integer('instagramlocations_id');
            $table->timestamps();
            $table->foreign('instagramusers_id')->references('id')->on('instagramusers');
            // $table->foreign('instagramlocations_id')->references('id')->on('instagramlocations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('instagramphotos');
    }
}
