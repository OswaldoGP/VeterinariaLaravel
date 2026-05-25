@extends('layouts.main')

@section('title', 'Confirmar Eliminación')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Confirmar Eliminación</h1>
        <a href="{{ route('expedientes.mascota.alergias', $mascota->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver
        </a>
    </div>

    <div class="card shadow mb-4 border-left-danger">
        <div class="card-body">
            <p class="mb-4">Estás a punto de eliminar la siguiente alergia del paciente <strong class="text-primary">{{ $mascota->nombre }}</strong>. <span class="text-danger font-weight-bold">Esta acción no se puede deshacer y sus datos no podrán ser recuperados.</span></p>

            <div class="table-responsive mb-4">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th class="bg-light" style="width: 25%;">Fecha de Registro</th>
                            <td>{{ $alergia->created_at->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Nombre de la Alergia</th>
                            <td>{{ $alergia->nombre }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Descripción</th>
                            <td>{{ $alergia->descripcion ?? 'N/A' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="alert alert-info shadow-sm mb-4">
                <i class="fas fa-info-circle mr-2"></i>
                <strong>Información de validación:</strong> Este registro se puede eliminar de manera segura si la alergia fue registrada por error o ya no es clínicamente relevante.
            </div>

            <form action="{{ route('expedientes.mascota.alergias.destroy', $alergia->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger shadow-sm">
                    <i class="fas fa-trash-alt mr-1"></i> Eliminar Definitivamente
                </button>
            </form>
            <a href="{{ route('expedientes.mascota.alergias', $mascota->id) }}" class="btn btn-secondary shadow-sm ml-2">
                Cancelar
            </a>
        </div>
    </div>
@endsection
