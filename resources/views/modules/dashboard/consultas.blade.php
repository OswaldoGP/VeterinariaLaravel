@extends('layouts.main')

@section('title', 'Consultas de ' . $mascota->nombre)

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Consultas Médicas: <span class="text-primary">{{ $mascota->nombre }}</span></h1>
        <a href="{{ route('expedientes.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver a Expedientes
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Información de la Mascota y Dueño -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Detalles del Paciente (Folio: {{ $mascota->id }})</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $mascota->especie }} - {{ $mascota->raza }}</div>
                            <div class="mt-2 text-muted small">
                                <div>Nacimiento: {{ $mascota->fecha_nacimiento ?? 'N/A' }}</div>
                                <div>Sangre: {{ $mascota->tipo_sangre ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-paw fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Información del Dueño</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $mascota->dueno->nombre_completo ?? 'Sin dueño' }}</div>
                            @if($mascota->dueno)
                                <div class="mt-2 text-muted small">
                                    <div>Teléfono: {{ $mascota->dueno->telefono ?? 'N/A' }}</div>
                                    <div>Dirección: {{ $mascota->dueno->direccion ?? 'N/A' }}</div>
                                </div>
                            @endif
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Historial de Consultas -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Historial de Consultas</h6>
            <a href="{{ route('expedientes.consultas.create', $mascota->id) }}" class="btn btn-sm btn-success shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Nueva Consulta
            </a>
        </div>
        <div class="card-body">
            @if($consultas && $consultas->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Veterinario</th>
                                <th>Peso/Talla</th>
                                <th>Diagnóstico</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($consultas as $consulta)
                                <tr>
                                    <td>{{ $consulta->fecha_consulta->format('d/m/Y H:i') }}</td>
                                    <td>{{ $consulta->veterinario->user->name ?? 'N/A' }}</td>
                                    <td>{{ $consulta->peso ?? '-' }} kg / {{ $consulta->talla ?? '-' }} cm</td>
                                    <td>{{ Str::limit(strip_tags($consulta->diagnostico), 50) }}</td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('expedientes.consultas.show', ['mascota' => $mascota->id, 'consulta' => $consulta->id]) }}" class="btn btn-sm btn-info" title="Ver Detalle">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('expedientes.consultas.edit', ['mascota' => $mascota->id, 'consulta' => $consulta->id]) }}" class="btn btn-sm btn-warning" title="Editar Consulta">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('expedientes.consultas.delete', ['mascota' => $mascota->id, 'consulta' => $consulta->id]) }}" class="btn btn-sm btn-danger" title="Eliminar Consulta">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    {{ $consultas->links('pagination::bootstrap-4') }}
                </div>
            @else
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-clipboard-list fa-3x mb-3 text-gray-300"></i>
                    <p>Este paciente aún no tiene consultas registradas.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
