<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;
    protected $table = 'cursos';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombre',
        'autor',
        'precio',
        'tiempo',
        'calificacion',
        'estado',
    ];

    // Relación con el modelo User
    public function autor()
    {
        return $this->belongsTo(User::class, 'autor', 'id');
    }
}
