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
        Schema::create('counter', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('jenis_koin', ['koin100', 'koin200', 'koin500', 'koin1000']);
            $table->dateTime('tanggal_jam')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counter');
    }
};
