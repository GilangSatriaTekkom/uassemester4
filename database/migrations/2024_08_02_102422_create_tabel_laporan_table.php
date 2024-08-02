<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTabelLaporanTable extends Migration
{
    public function up()
    {
        Schema::create('tabel_laporan', function (Blueprint $table) {
            $table->bigIncrements('Id_laporan');
            $table->date('tanggal');
            $table->time('jam');
            $table->integer('jumlah_koin_100');
            $table->integer('jumlah_koin_200');
            $table->integer('jumlah_koin_500');
            $table->integer('jumlah_koin_1000');
            $table->decimal('jumlah_rupiah', 15, 2);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('nama_nasabah')->nullable();
            $table->unsignedBigInteger('nama_pegawai')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tabel_laporan');
    }
}
