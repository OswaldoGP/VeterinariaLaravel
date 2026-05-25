@extends('layouts.main')

@section('title', 'Detalle de Lesión - ' . $mascota->nombre)

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detalle de Lesión</h1>
        <a href="{{ route('expedientes.mascota.lesiones', $mascota->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver
        </a>
    </div>

    <div class="card shadow mb-4 border-left-info">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-info">Información de la Lesión</h6>
            <div class="dropdown no-arrow">
                <a href="{{ route('expedientes.mascota.lesiones.edit', $lesion->id) }}" class="btn btn-warning btn-sm shadow-sm" title="Editar">
                    <i class="fas fa-edit"></i> Editar
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-borderless table-striped">
                    <tbody>
                        <tr>
                            <th class="text-right" style="width: 30%;">Paciente:</th>
                            <td><strong class="text-primary">{{ $mascota->nombre }}</strong></td>
                        </tr>
                        <tr>
                            <th class="text-right">Fecha de Registro:</th>
                            <td>{{ $lesion->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th class="text-right">Tipo de Lesión:</th>
                            <td><span class="badge badge-warning" style="font-size: 1rem;">{{ $lesion->tipo }}</span></td>
                        </tr>
                        <tr>
                            <th class="text-right align-middle">Descripción / Observaciones:</th>
                            <td>
                                <div class="p-3 bg-light border rounded">
                                    {{ $lesion->descripcion ?? 'Sin observaciones registradas.' }}
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
