@extends('layouts.client')

@section('content')
<div class="container">
    <h1>Mis Cursos</h1>
    @foreach ($cursos->groupBy('categoria.nombre') as $categoria => $cursosPorCategoria)
        <h2>{{ $categoria }}</h2>
        <div class="row">
            @foreach ($cursosPorCategoria as $curso)
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $curso->nombre }}</h5>
                            <p class="card-text">{{ $curso->descripcion }}</p>
                            <p><strong>Estado:</strong> {{ $curso->estado }}</p>

                            <!-- Condición para materiales didácticos -->
                          
                            <a href="{{ route('curso.detalles', $curso->id) }}" class="btn btn-success">
                                Ver Detalles
                            </a>


                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
@endsection
