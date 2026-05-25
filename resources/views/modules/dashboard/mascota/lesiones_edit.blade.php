@extends('layouts.main')

@section('title', 'Editar Lesión - ' . $mascota->nombre)

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Editar Lesión</h1>
        <a href="{{ route('expedientes.mascota.lesiones', $mascota->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Actualizar Información de Lesión</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('expedientes.mascota.lesiones.update', $lesion->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="font-weight-bold">Tipo de Lesión *</label>
                            <input type="text" class="form-control" name="tipo" value="{{ old('tipo', $lesion->tipo) }}" required>
                            @error('tipo') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="font-weight-bold">Descripción / Observaciones</label>
                            <textarea class="form-control" name="descripcion" rows="3">{{ old('descripcion', $lesion->descripcion) }}</textarea>
                            @error('descripcion') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>

                <hr class="mt-4 mb-4">
                <div class="text-right">
                    <button type="submit" class="btn btn-primary shadow-sm"><i class="fas fa-save mr-1"></i> Actualizar Lesión</button>
                </div>
            </form>
        </div>
    </div>
@endsection
