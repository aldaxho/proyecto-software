
@extends('Layouts.admin')

@section('content')
<div class="container">
<h1>Usuarios</h1>
<p>Gestión de usuarios aquí.</p>
    <!-- Botón para abrir el modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearUsuariosModal">
        Crear usuarios
    </button>
   
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->id }}</td>
                    <td>{{ $usuario->nombre }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>
                        <button href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-warning"data-bs-toggle="modal" data-bs-target="#editarUsuarioModal{{ $usuario->id }}">Editar</button>
                        
                        <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @include('admin.modals.crud-usuario.editarUsuario', ['usuario' => $usuario])
            @endforeach
        </tbody>
    </table>
    <!-- Incluir el modal -->
    @include('admin.modals.crud-usuario.crearUsuarios_modal')
   
</div>
@endsection
