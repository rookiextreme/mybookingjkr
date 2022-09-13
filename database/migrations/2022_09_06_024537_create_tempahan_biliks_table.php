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
        Schema::create('tempahan_biliks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('users_id');
            $table->integer('bangunan_biliks_id');
            $table->text('nama');
            $table->dateTime('masa_mula');
            $table->dateTime('masa_tamat');
            $table->bigInteger('nokp_urusetia');
            $table->text('tel_urusetia');
            $table->text('pengerusi');
            $table->integer('bil_agensi_d');
            $table->integer('bil_agensi_l');
            $table->text('nota')->nullable();
            $table->integer('status');
            $table->integer('flag');
            $table->integer('delete_id');
            $table->timestamps();
        });

        Schema::table('tempahan_biliks', function(Blueprint $table){
            $table->foreign('bangunan_biliks_id')->references('id')->on('bangunan_biliks');
            $table->foreign('users_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tempahan_biliks');
    }
};
