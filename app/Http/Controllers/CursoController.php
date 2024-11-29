<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Categoria;
use App\Models\Usuario;
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


    public function cursosshow(){
        $cursos= Curso::all();
        return view('client.courses.index', compact('cursos'));
    }



    /*mis cursos creados por mi */
    public function misCursos()
    {
        // Obtener el usuario autenticado con el guard 'usuarios'
        $user = Auth::user();
             // Obtener los cursos creados por el usuario
                $cursos = Curso::where('autor', $user->id)
                ->with('categoria', 'materialesDidacticos')
                ->get();

            return view('client.courses.mis-cursos', compact('cursos'));
    }

    public function detalles($id)
    {
        // Obtener el curso por ID, incluyendo los usuarios y materiales didácticos
        $curso = Curso::with(['usuarios', 'materialesDidacticos'])->findOrFail($id);

        // Usuarios que compraron el curso
        $usuarios = $curso->usuarios;

        // Materiales didácticos asociados al curso
        $materiales = $curso->materialesDidacticos;

        return view('client.courses.detalles', compact('curso', 'usuarios', 'materiales'));
    }

    public function show($id)
    {
        // $curso = Curso::with('materiales')->findOrFail($id);

        // $usuario = Auth::user();
        // if (!$usuario) {
        //     return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder a los cursos.');
        // }

        // // Verificar si el usuario ha comprado el curso
        // $haCompradoCurso = $usuario->compras()->where('curso_id', $curso->id)->exists();

        // // Verificar si el usuario es suscriptor
        // $esSuscriptor = $usuario->es_suscriptor; // Cambia esto según tu lógica de suscripciones

        // // Pasar datos a la vista
        // return view('client.courses.show', [
        //     'curso' => $curso,
        //     'haCompradoCurso' => $haCompradoCurso,
        //     'esSuscriptor' => $esSuscriptor,
        // ]);

        return view('suscripciones/plan');
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
