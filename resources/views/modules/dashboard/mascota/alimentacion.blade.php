@extends('layouts.main')

@section('title', 'Alimentación - ' . $mascota->nombre)

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Alimentación e Historial Dietético</h1>
    </div>

    <!-- Breadcrumb -->
    <div class="card shadow-sm mb-4">
        <div class="card-body py-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('expedientes.index') }}">Expedientes</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('expedientes.consultas', $mascota->id) }}">{{ $mascota->nombre }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Alimentación</li>
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
        <!-- Formulario para agregar alimentación -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Registrar Plan Alimenticio</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('expedientes.mascota.alimentacion.store', $mascota->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="alimento">Tipo de Alimento / Marca *</label>
                            <input type="text" class="form-control" id="alimento" name="alimento" placeholder="Ej. Croquetas Royal Canin" required>
                        </div>
                        <div class="form-group">
                            <label for="cantidad">Cantidad por ración</label>
                            <input type="text" class="form-control" id="cantidad" name="cantidad" placeholder="Ej. 100g, 1 taza">
                        </div>
                        <div class="form-group">
                            <label for="frecuencia">Frecuencia / Tiempo</label>
                            <input type="text" class="form-control" id="frecuencia" name="frecuencia" placeholder="Ej. 2 veces al día por 1 mes">
                            <small class="form-text text-muted">Ejemplo: el alimento que le toca por una x cantidad de tiempo.</small>
                        </div>
                        <div class="form-group">
                            <label for="observaciones">Observaciones</label>
                            <textarea class="form-control" id="observaciones" name="observaciones" rows="2"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Guardar</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Lista de Alimentación -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Historial Dietético</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Alimento</th>
                                    <th>Cantidad</th>
                                    <th>Frecuencia</th>
                                    <th>Observaciones</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mascota->alimentaciones as $alimentacion)
                                <tr>
                                    <td>{{ $alimentacion->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $alimentacion->alimento }}</td>
                                    <td>{{ $alimentacion->cantidad }}</td>
                                    <td>{{ $alimentacion->frecuencia }}</td>
                                    <td>{{ $alimentacion->observaciones }}</td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('expedientes.mascota.alimentacion.show', $alimentacion->id) }}" class="btn btn-info btn-sm" title="Ver Detalle">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('expedientes.mascota.alimentacion.edit', $alimentacion->id) }}" class="btn btn-warning btn-sm" title="Editar Alimentación">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('expedientes.mascota.alimentacion.delete', $alimentacion->id) }}" class="btn btn-danger btn-sm" title="Eliminar Alimentación">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No hay registros de alimentación para esta mascota.</td>
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
