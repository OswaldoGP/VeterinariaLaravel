@extends('layouts.main')

@section('title', 'Editar Alimentación - ' . $mascota->nombre)

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Editar Alimentación</h1>
        <a href="{{ route('expedientes.mascota.alimentacion', $mascota->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Actualizar Registro de Alimentación</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('expedientes.mascota.alimentacion.update', $alimentacion->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold">Tipo de Alimento / Marca *</label>
                            <input type="text" class="form-control" name="alimento" value="{{ old('alimento', $alimentacion->alimento) }}" required>
                            @error('alimento') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold">Cantidad (ej. 200g)</label>
                            <input type="text" class="form-control" name="cantidad" value="{{ old('cantidad', $alimentacion->cantidad) }}">
                            @error('cantidad') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold">Frecuencia (ej. 2 veces al día)</label>
                            <input type="text" class="form-control" name="frecuencia" value="{{ old('frecuencia', $alimentacion->frecuencia) }}">
                            @error('frecuencia') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="font-weight-bold">Observaciones / Notas adicionales</label>
                            <textarea class="form-control" name="observaciones" rows="3">{{ old('observaciones', $alimentacion->observaciones) }}</textarea>
                            @error('observaciones') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>

                <hr class="mt-4 mb-4">
                <div class="text-right">
                    <button type="submit" class="btn btn-primary shadow-sm"><i class="fas fa-save mr-1"></i> Actualizar Registro</button>
                </div>
            </form>
        </div>
    </div>
@endsection
