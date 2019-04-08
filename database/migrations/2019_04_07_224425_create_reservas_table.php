<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre_cliente', 50);
            $table->string('apellido_cliente', 50);
            $table->dateTime('fecha_nacimiento');
            $table->dateTime('inicio_reserva');
            $table->dateTime('fin_reserva');
            $table->string('habitacion');
            $table->float('costo');
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
        Schema::dropIfExists('reservas');
    }
}
