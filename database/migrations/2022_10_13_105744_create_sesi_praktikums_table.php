<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSesiPraktikumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sesi_praktikums', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jadwal_praktikum_id');
            $table->string('sesi');
            $table->integer('jumlah_peserta');
            $table->timestamps();

            $table->foreign('jadwal_praktikum_id')->references('id')->on('jadwal_praktikums');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sesi_praktikums');
    }
}
