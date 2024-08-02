<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTabelRekeningTable extends Migration
{
    public function up()
    {
        Schema::create('tabel_rekening', function (Blueprint $table) {
            $table->string('nomor_rekening', 50);
            $table->integer('jumlah_tabungan')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('id');
            $table->primary('nomor_rekening');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tabel_rekening');
    }
}
