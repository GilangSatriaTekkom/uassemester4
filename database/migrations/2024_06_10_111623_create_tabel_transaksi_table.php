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
    Schema::create('tabel_transaksi', function (Blueprint $table) {
        $table->id('Id_transaksi');
        $table->unsignedBigInteger('Id_nasabah');
        $table->string('tipe_transaksi', 50);
        $table->decimal('jumlah_transaksi', 15, 2);
        $table->date('tanggal_transaksi');
        $table->timestamps();

         // Foreign key constraint
         $table->foreign('Id_nasabah')->references('Id_nasabah')->on('tabel_nasabah');
    });
}

public function down()
{
    Schema::dropIfExists('tabel_transaksi');
}

};
