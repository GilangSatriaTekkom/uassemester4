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
    Schema::create('tabel_auto_transaksi', function (Blueprint $table) {
        $table->id('Id_auto');
        $table->unsignedBigInteger('Id_rekening');
        $table->string('tipe_transaksi', 50);
        $table->unsignedBigInteger('penerima_transaksi');
        $table->decimal('jumlah_transaksi', 15, 2);
        $table->date('tanggal_transaksi');
        $table->string('status_transaksi', 50);
        $table->timestamps();

        // Foreign key constraints
        $table->foreign('Id_rekening')->references('Id_rekening')->on('tabel_rekening');
        $table->foreign('penerima_transaksi')->references('Id_nasabah')->on('tabel_nasabah');
    });
}

public function down()
{
    Schema::dropIfExists('tabel_auto_transaksi');
}

};
