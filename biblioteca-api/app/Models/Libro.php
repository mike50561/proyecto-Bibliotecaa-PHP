<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Libro extends Model
{
    use HasFactory;

    protected $table = 'libros';

    protected $fillable = ['titulo', 'autor', 'editorial', 'anio', 'isbn', 'categoria', 'cantidad'];

    // Un libro puede estar en muchos préstamos
    public function prestamos()
    {
        return $this->hasMany(Prestamo::class);
    }
}
