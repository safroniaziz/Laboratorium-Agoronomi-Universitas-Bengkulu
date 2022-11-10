<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProdiKodeColumnToProdisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prodis', function (Blueprint $table) {
            $table->string('kode_prodi')->after('nama_prodi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prodis', function (Blueprint $table) {
            $table->dropColumn('prodi_kode');
            $table->dropColumn('kode_prodi');
        });
    }
}
