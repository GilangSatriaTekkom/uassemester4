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
    Schema::create('tabel_rekening', function (Blueprint $table) {
        $table->id('Id_rekening');
        $table->unsignedBigInteger('Id_nasabah');
        $table->foreign('Id_nasabah')->references('Id_nasabah')->on('tabel_nasabah');
        $table->string('nomor_akun', 50);
        $table->decimal('jumlah_tabungan', 15, 2);
        $table->date('tanggal_buat');
        $table->date('tanggal_update')->nullable();
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('tabel_rekening');
}

};
