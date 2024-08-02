<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiOtomatisTable extends Migration
{
    public function up()
    {
        Schema::create('transaksi_otomatis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_user');
            $table->string('nama_penerima');
            $table->string('nomor_rekening', 50);
            $table->decimal('jumlah_transfer', 10, 2);
            $table->dateTime('interval');
            $table->enum('status', ['Aktif', 'Bermasalah', '1_minggu', '1_bulan', 'Sesuai_tanggal', 'Selesai'])->default('Aktif');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'))->onUpdate(DB::raw('CURRENT_TIMESTAMP'));
            $table->time('waktu')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksi_otomatis');
    }
}
