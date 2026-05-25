@extends('layouts.main')

@section('title', 'Lesiones - ' . $mascota->nombre)

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Lesiones</h1>
    </div>

    <!-- Breadcrumb -->
    <div class="card shadow-sm mb-4">
        <div class="card-body py-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('expedientes.index') }}">Expedientes</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('expedientes.consultas', $mascota->id) }}">{{ $mascota->nombre }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Lesiones</li>
                </ol>
            </nav>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <!-- Formulario para agregar lesión -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Agregar Nueva Lesión</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('expedientes.mascota.lesiones.store', $mascota->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="tipo">Tipo de Lesión *</label>
                            <input type="text" class="form-control" id="tipo" name="tipo" placeholder="Ej. Fractura, Corte" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción / Observaciones</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Guardar</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Lista de Lesiones -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Historial de Lesiones</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Tipo</th>
                                    <th>Descripción</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mascota->lesiones as $lesion)
                                <tr>
                                    <td>{{ $lesion->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $lesion->tipo }}</td>
                                    <td>{{ $lesion->descripcion }}</td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('expedientes.mascota.lesiones.show', $lesion->id) }}" class="btn btn-info btn-sm" title="Ver Detalle">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('expedientes.mascota.lesiones.edit', $lesion->id) }}" class="btn btn-warning btn-sm" title="Editar Lesión">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('expedientes.mascota.lesiones.delete', $lesion->id) }}" class="btn btn-danger btn-sm" title="Eliminar Lesión">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No hay lesiones registradas para esta mascota.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
