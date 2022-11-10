<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesertaPraktikumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peserta_praktikums', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sesi_praktikum_id');
            $table->string('nama_lengkap');
            $table->string('npm');
            $table->string('prodi');
            $table->timestamps();

            $table->foreign('sesi_praktikum_id')->references('id')->on('sesi_praktikums');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peserta_praktikums');
    }
}
