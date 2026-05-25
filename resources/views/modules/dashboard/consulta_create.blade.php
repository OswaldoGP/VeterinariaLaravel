@extends('layouts.main')

@section('title', 'Nueva Consulta - ' . $mascota->nombre)

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Nueva Consulta: <span class="text-primary">{{ $mascota->nombre }}</span></h1>
        <a href="{{ route('expedientes.consultas', $mascota->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver a Consultas
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Registrar Nueva Consulta Médica</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('expedientes.consultas.store', $mascota->id) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Veterinario Atendiendo *</label>
                            <select name="veterinario_id" class="form-control" required>
                                <option value="">Seleccione un veterinario...</option>
                                @foreach($veterinarios as $vet)
                                    <option value="{{ $vet->id }}">{{ $vet->user->name }} - {{ $vet->especialidad ?? 'General' }}</option>
                                @endforeach
                            </select>
                            @error('veterinario_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Fecha de la Consulta *</label>
                            <input type="datetime-local" class="form-control" name="fecha_consulta" value="{{ old('fecha_consulta', now()->format('Y-m-d\TH:i')) }}" required>
                            @error('fecha_consulta') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>

                <h6 class="font-weight-bold text-secondary mt-4 mb-3">Signos Vitales y Medidas</h6>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Peso (kg)</label>
                            <input type="number" step="0.01" class="form-control" name="peso" value="{{ old('peso') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Talla (cm)</label>
                            <input type="number" step="0.01" class="form-control" name="talla" value="{{ old('talla') }}">
                        </div>
                    </div>
                </div>

                <h6 class="font-weight-bold text-secondary mt-4 mb-3">Detalles Clínicos Iniciales</h6>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="font-weight-bold">Diagnóstico Presuntivo / Definitivo</label>
                            <textarea class="form-control" name="diagnostico" rows="4">{{ old('diagnostico') }}</textarea>
                        </div>
                    </div>
                </div>

                <hr class="mt-4 mb-4">
                <div class="text-right">
                    <button type="submit" class="btn btn-primary shadow-sm"><i class="fas fa-save mr-1"></i> Guardar Consulta</button>
                </div>
            </form>
        </div>
    </div>
@endsection
