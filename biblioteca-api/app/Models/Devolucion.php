<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Devolucion extends Model
{
    use HasFactory;

    protected $table = 'devoluciones';

    protected $fillable = ['prestamo_id', 'fecha_real', 'multa'];

    // Una devolución pertenece a un préstamo
    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class);
    }
}
