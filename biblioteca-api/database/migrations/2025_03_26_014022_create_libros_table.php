<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('libros', function (Blueprint $table) {
        $table->id();
        $table->string('titulo');
        $table->string('autor');
        $table->string('editorial')->nullable();
        $table->integer('anio')->nullable();
        $table->string('isbn')->nullable();
        $table->string('categoria')->nullable();
        $table->integer('cantidad')->default(1);
        $table->timestamps(); // crea created_at y updated_at
    });
}

    public function down(): void
    {
        Schema::dropIfExists('libros');
    }
};
