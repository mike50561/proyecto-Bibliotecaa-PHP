<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('devoluciones', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('prestamo_id');
        $table->date('fecha_real');
        $table->decimal('multa', 10, 2)->nullable();
        $table->timestamps();

        $table->foreign('prestamo_id')->references('id')->on('prestamos')->onDelete('cascade');
    });
}

    public function down(): void
    {
        Schema::dropIfExists('devolucions');
    }
};
