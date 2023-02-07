<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bilik_fasilitis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('biliks_id');
            $table->integer('fasilitis_id');
            $table->integer('kuantiti');
            $table->integer('flag');
            $table->integer('delete_id');
            $table->timestamps();
        });

        Schema::table('bilik_fasilitis', function(Blueprint $table){
            $table->foreign('biliks_id')->references('id')->on('bangunan_biliks');
            $table->foreign('fasilitis_id')->references('id')->on('fasilitis');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bilik_fasilitis');
    }
};
