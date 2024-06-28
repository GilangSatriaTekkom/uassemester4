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
    Schema::create('tabel_pegawai', function (Blueprint $table) {
        $table->id('Id_pegawai');
        $table->string('nama_pegawai', 100);
        $table->text('alamat');
        $table->char('gender', 1);
        $table->string('no_hp', 15);
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('tabel_pegawai');
}

};