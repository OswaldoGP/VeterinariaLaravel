@extends('layouts.main')

@section('title', 'Confirmar Eliminación')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Confirmar Eliminación</h1>
        <a href="{{ route('expedientes.consultas', $mascota->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver
        </a>
    </div>

    <div class="card shadow mb-4 border-left-danger">
        <div class="card-body">
            <p class="mb-4">Estás a punto de eliminar la siguiente consulta del paciente <strong class="text-primary">{{ $mascota->nombre }}</strong>. <span class="text-danger font-weight-bold">Esta acción no se puede deshacer y sus datos clínicos no podrán ser recuperados.</span></p>

            <div class="table-responsive mb-4">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th class="bg-light" style="width: 25%;">ID de Consulta</th>
                            <td>{{ $consulta->id }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Fecha y Hora</th>
                            <td>{{ \Carbon\Carbon::parse($consulta->fecha_consulta)->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Veterinario Atendió</th>
                            <td>{{ $consulta->veterinario->user->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Diagnóstico</th>
                            <td>
                                @if($consulta->diagnostico)
                                    {{ Str::limit(strip_tags($consulta->diagnostico), 100) }}
                                @else
                                    <span class="text-muted">Sin diagnóstico registrado</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="alert alert-info shadow-sm mb-4">
                <i class="fas fa-info-circle mr-2"></i>
                <strong>Información de validación:</strong> La consulta se puede eliminar de manera segura. Sin embargo, ten en cuenta que el historial médico de esta fecha se perderá por completo para este paciente.
            </div>

            <form action="{{ route('expedientes.consultas.destroy', ['mascota' => $mascota->id, 'consulta' => $consulta->id]) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger shadow-sm">
                    <i class="fas fa-trash-alt mr-1"></i> Eliminar Definitivamente
                </button>
            </form>
            <a href="{{ route('expedientes.consultas', $mascota->id) }}" class="btn btn-secondary shadow-sm ml-2">
                Cancelar
            </a>
        </div>
    </div>
@endsection
