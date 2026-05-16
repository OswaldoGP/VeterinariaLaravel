@extends('layouts.admin')

@section('title', 'Eliminar Usuario')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Confirmar Eliminación</h1>
        <a href="{{ route('admin.users.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i
                class="fas fa-arrow-left fa-sm text-white-50"></i> Volver</a>
    </div>

    <div class="card shadow mb-4 border-left-danger">
        <div class="card-header py-3 bg-danger">
            <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-exclamation-triangle"></i> ¡Atención! Acción irreversible</h6>
        </div>
        <div class="card-body">
            <p class="text-gray-800 text-lg">Estás a punto de eliminar al siguiente usuario del sistema. <strong class="text-danger">Esta acción no se puede deshacer y sus datos no podrán ser recuperados.</strong></p>
            
            <div class="table-responsive mb-4">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th class="bg-light" style="width: 200px;">ID</th>
                            <td>{{ $user->id }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Nombre</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Rol</th>
                            <td><span class="badge badge-primary">{{ ucfirst($user->rol) }}</span></td>
                        </tr>
                        @if($user->rol === 'veterinario' && $user->veterinario)
                            <tr>
                                <th class="bg-light">Especialidad (Veterinario)</th>
                                <td>{{ $user->veterinario->especialidad ?? 'N/A' }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            @if ($hasDependencies)
                <div class="alert alert-warning mb-4">
                    <strong><i class="fas fa-exclamation-circle"></i> No se puede eliminar:</strong> 
                    Este usuario contiene datos o registros asociados en otros módulos (por ejemplo: dependencias por llaves foráneas). 
                    Primero debes reasignar o eliminar esos datos para poder continuar.
                </div>
                <button class="btn btn-danger px-4" disabled>Eliminar Definitivamente</button>
            @else
                <div class="alert alert-info mb-4">
                    <strong><i class="fas fa-info-circle"></i> Información de validación:</strong> 
                    El usuario solo existe en los registros base (usuarios/perfil de veterinario), por lo que cumple con las condiciones y <strong>se puede eliminar de manera segura</strong>.
                </div>
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-4">
                        <i class="fas fa-trash"></i> Eliminar Definitivamente
                    </button>
                </form>
            @endif
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary px-4 ml-2">Cancelar</a>
        </div>
    </div>
@endsection
