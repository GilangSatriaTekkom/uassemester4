<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToggleTable extends Migration
{
    public function up()
    {
        Schema::create('toggle', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('value');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'))->onUpdate(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    public function down()
    {
        Schema::dropIfExists('toggle');
    }
}
