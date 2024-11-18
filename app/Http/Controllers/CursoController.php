<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Categoria;
use Illuminate\Support\Facades\Auth;
class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cursos= Curso::All();
        $categorias = Categoria::all();
        $userId=session('usuario_id');
        $userNombre=session('usuario_nombre');
        return view('client.courses.create', compact('cursos','categorias','userId','userNombre'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       // dd($request->all());
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'autor' => 'required|integer',
            'categoria_id' => 'required|exists:categorias,id', 
            'precio' => 'required|numeric',
            'tiempo' => 'required|integer',
            'estado' => 'required|string|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $cursoData = $request->all();
       
        // Manejar la carga de la imagen
        if ($request->hasFile('imagen')) {
            $imageName = time() . '.' . $request->imagen->extension();
            $request->imagen->move(public_path('imagenes/cursos'), $imageName);
            $cursoData['imagen'] = 'imagenes/cursos/' . $imageName;
        }
       // dd($cursoData);
        Curso::create($cursoData);
    
        return redirect()->route('client.courses.create')->with('success', 'Curso creado exitosamente');
    }
    

    /**
     * Display the specified resource.
     */
  

    /**
     * Show the form for editing the specified resource.
     */
  

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
