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
        'descripcion',
        'autor',
        'categoria_id',
        'precio',
        'tiempo',
        'calificacion',
        'estado',
        'fecha_creacion', 
        'imagen',
    ];

    // Relación con el modelo User
    public function autor()
    {
        return $this->belongsTo(User::class, 'autor', 'id');
    }
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

}
