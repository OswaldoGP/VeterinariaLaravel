@extends('layouts.main')

@section('title', 'Confirmar Eliminación')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Confirmar Eliminación</h1>
        <a href="{{ route('expedientes.mascota.alimentacion', $mascota->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver
        </a>
    </div>

    <div class="card shadow mb-4 border-left-danger">
        <div class="card-body">
            <p class="mb-4">Estás a punto de eliminar el siguiente registro de alimentación del paciente <strong class="text-primary">{{ $mascota->nombre }}</strong>. <span class="text-danger font-weight-bold">Esta acción no se puede deshacer y sus datos no podrán ser recuperados.</span></p>

            <div class="table-responsive mb-4">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th class="bg-light" style="width: 25%;">Fecha de Registro</th>
                            <td>{{ $alimentacion->created_at->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Tipo de Alimento</th>
                            <td>{{ $alimentacion->alimento }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Cantidad</th>
                            <td>{{ $alimentacion->cantidad ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Frecuencia</th>
                            <td>{{ $alimentacion->frecuencia ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Observaciones</th>
                            <td>{{ $alimentacion->observaciones ?? 'N/A' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="alert alert-info shadow-sm mb-4">
                <i class="fas fa-info-circle mr-2"></i>
                <strong>Información de validación:</strong> Este registro se puede eliminar de manera segura si la dieta fue registrada por error o es demasiado antigua y ya no es relevante.
            </div>

            <form action="{{ route('expedientes.mascota.alimentacion.destroy', $alimentacion->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger shadow-sm">
                    <i class="fas fa-trash-alt mr-1"></i> Eliminar Definitivamente
                </button>
            </form>
            <a href="{{ route('expedientes.mascota.alimentacion', $mascota->id) }}" class="btn btn-secondary shadow-sm ml-2">
                Cancelar
            </a>
        </div>
    </div>
@endsection
