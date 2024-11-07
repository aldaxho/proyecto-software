<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    public $timestamps = false; // Si no tienes campos de timestamp

    protected $fillable = [
        'nombre',
        'apellido',
        'correo',
        'contrasena',
        'fecha_nacimiento',
        'rol_id'
    ];

    protected $hidden = [
        'contrasena',
    ];

    // Método para indicar a Laravel cuál es el campo de contraseña
    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    // Relación con el rol
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }
}
