@extends('layouts.client')

@section('content')
<div class="container">
    <h1>Detalles del Curso: {{ $curso->nombre }}</h1>

    <div class="row">
        <!-- Sección de Usuarios -->
        <div class="col-md-6">
            <h2>Usuarios Inscritos</h2>
            @if ($usuarios->isEmpty())
                <p>No hay usuarios inscritos en este curso.</p>
            @else
                <ul class="list-group">
                    @foreach ($usuarios as $usuario)
                        <li class="list-group-item">
                            {{ $usuario->nombre }} - {{ $usuario->correo }}
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <!-- Sección de Material Didáctico -->
        <div class="col-md-6">
            <h2>Material Didáctico</h2>
            @if ($materiales->isEmpty())
                <p>No hay material didáctico para este curso.</p>
            @else
                <ul class="list-group">
                    @foreach ($materiales as $material)
                        <li class="list-group-item">
                            <a href="{{ asset('storage/' . $material->archivo) }}" target="_blank">
                                {{ $material->descripcion }} ({{ $material->tipo }})
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif

            <!-- Botón para agregar nuevo material -->
            <a href="{{ route('material.create', $curso->id) }}" class="btn btn-primary mt-3">
                Agregar Material Didáctico
            </a>
        </div>
    </div>
</div>
@endsection
