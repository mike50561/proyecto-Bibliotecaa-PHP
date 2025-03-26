<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'usuarios';

    protected $fillable = ['nombre', 'correo', 'password', 'tipo_usuario'];

    protected $hidden = ['password', 'remember_token'];

    // Un usuario tiene muchos préstamos
    public function prestamos()
    {
        return $this->hasMany(Prestamo::class);
    }
}
