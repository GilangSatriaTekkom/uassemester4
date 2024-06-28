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
    Schema::create('tabel_notifikasi', function (Blueprint $table) {
        $table->id('Id_notif');
        $table->unsignedBigInteger('Id_nasabah');
        $table->text('pesan');
        $table->boolean('is_read');
        $table->date('tanggal_buat');
        $table->timestamps();

        // Foreign key constraint
        $table->foreign('Id_nasabah')->references('Id_nasabah')->on('tabel_nasabah');
    });
}

public function down()
{
    Schema::dropIfExists('tabel_notifikasi');
}

};
