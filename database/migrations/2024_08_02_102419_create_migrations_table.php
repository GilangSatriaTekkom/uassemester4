<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMigrationsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('migrations')) { // Check if the table already exists
            Schema::create('migrations', function (Blueprint $table) {
                $table->increments('id');
                $table->string('migration');
                $table->integer('batch');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('migrations');
    }
}
