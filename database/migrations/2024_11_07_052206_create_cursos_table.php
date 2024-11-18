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
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion');
            $table->foreignId('autor')->constrained('usuarios')->onDelete('cascade'); // Relación con la tabla de usuarios
            $table->decimal('precio', 8, 2);
            $table->string('tiempo'); // Ejemplo: "3 meses"
            $table->decimal('calificacion', 3, 2)->default(0);
            $table->string('estado'); // Ejemplo: "activo", "inactivo"
            $table->string('imagen')->nullable(); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
