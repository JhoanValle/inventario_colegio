<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('prestamos', function (Blueprint $table) {
    $table->id();

    // 🔗 RELACIÓN
    $table->foreignId('equipo_id')->constrained()->onDelete('cascade');

    // 📍 INFO
    $table->string('area');
    $table->string('responsable');

    // 📅 FECHAS
    $table->date('fecha_prestamo');
    $table->date('fecha_limite')->nullable(); // 🔥 NUEVO
    $table->date('fecha_devolucion')->nullable();

    // 🔄 ESTADO
    $table->enum('estado', ['Prestado', 'Devuelto', 'Retrasado'])
          ->default('Prestado');

    // 📝 OBSERVACIÓN
    $table->text('observacion')->nullable();

    // ⚡ OPTIMIZACIÓN
    $table->index('estado');
    $table->index('fecha_prestamo');

    $table->timestamps();
});
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestamos');
    }
};
