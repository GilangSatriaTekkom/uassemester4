<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTabelTransaksiTable extends Migration
{
    public function up()
    {
        Schema::create('tabel_transaksi', function (Blueprint $table) {
            $table->bigIncrements('Id_transaksi');
            $table->enum('tipe_transaksi', ['withdrawal', 'deposit', 'transfer', '']);
            $table->decimal('jumlah_transaksi', 15, 2);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tabel_transaksi');
    }
}
