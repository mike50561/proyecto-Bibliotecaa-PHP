<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prestamo extends Model
{
    use HasFactory;

    protected $table = 'prestamos';

    protected $fillable = ['usuario_id', 'libro_id', 'fecha_prestamo', 'fecha_devolucion', 'estado'];

    // Un préstamo pertenece a un usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    // Un préstamo pertenece a un libro
    public function libro()
    {
        return $this->belongsTo(Libro::class);
    }

    // Un préstamo puede tener una devolución
    public function devolucion()
    {
        return $this->hasOne(Devolucion::class);
    }
}
