<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLigasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ligas', function (Blueprint $table) {
            $table->id();
            $table->integer('image_id')->nullable();
            $table->string('nombre_liga')->nullable();
            $table->string('temporada_id')->nullable();
            $table->integer('tipo_id')->nullable();
            $table->integer('rama_id')->nullable();
            $table->string('sede_id')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->integer('estatu_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ligas');
    }
}
