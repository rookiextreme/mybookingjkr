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
        Schema::create('bangunans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('lokasis_id');
            $table->text('nama');
            $table->integer('flag');
            $table->integer('delete_id');
            $table->timestamps();
        });

        Schema::table('bangunans', function(Blueprint $table){
            $table->foreign('lokasis_id')->references('id')->on('lokasis');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bangunans');
    }
};
