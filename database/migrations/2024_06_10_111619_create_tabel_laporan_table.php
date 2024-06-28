<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('tabel_laporan', function (Blueprint $table) {
        $table->id('Id_laporan');
        $table->date('tanggal');
        $table->time('jam');
        $table->unsignedBigInteger('nama_pegawai');
        $table->unsignedBigInteger('nama_nasabah');
        $table->integer('jumlah_koin_100');
        $table->integer('jumlah_koin_200');
        $table->integer('jumlah_koin_500');
        $table->integer('jumlah_koin_1000');
        $table->decimal('jumlah_rupiah', 15, 2);
        $table->timestamps();

        $table->foreign('nama_pegawai')->references('Id_pegawai')->on('tabel_pegawai');
        $table->foreign('nama_nasabah')->references('Id_nasabah')->on('tabel_nasabah');
    });
}

public function down()
{
    Schema::dropIfExists('tabel_laporan');
}

};
