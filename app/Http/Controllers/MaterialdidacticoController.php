<?php
namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\MaterialDidactico;
use Illuminate\Http\Request;

class MaterialDidacticoController extends Controller
{
    // Mostrar los materiales de un curso
    public function verMateriales($cursoId)
    {
        $curso = Curso::with('materialesDidacticos')->findOrFail($cursoId);

        return view('client.materiales.cursos-material', compact('curso'));
    }

    // Mostrar formulario para agregar un nuevo material
    public function crearMaterial($cursoId)
    {
        $curso = Curso::findOrFail($cursoId);

        return view('materiales.crear', compact('curso'));
    }

    // Guardar un nuevo material
    public function guardarMaterial(Request $request, $cursoId)
    {
        $request->validate([
            'descripcion' => 'nullable|string',
            'archivo' => 'required|file',
            'tipo' => 'required|string',
        ]);

        $curso = Curso::findOrFail($cursoId);

        // Subir archivo
        $archivo = $request->file('archivo')->store('materiales/' . $cursoId, 'public');

        MaterialDidactico::create([
            'descripcion' => $request->input('descripcion'),
            'archivo' => $archivo,
            'tipo' => $request->input('tipo'),
            'curso_id' => $cursoId,
        ]);

        return redirect()->route('materiales.ver', $cursoId)->with('success', 'Material agregado correctamente.');
    }
}
