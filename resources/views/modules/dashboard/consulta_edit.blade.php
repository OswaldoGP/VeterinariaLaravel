@extends('layouts.main')

@section('title', 'Editar Consulta - ' . $mascota->nombre)

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Editar Consulta: <span class="text-primary">{{ $mascota->nombre }}</span></h1>
        <a href="{{ route('expedientes.consultas', $mascota->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver a Consultas
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Actualizar Información de Consulta</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('expedientes.consultas.update', ['mascota' => $mascota->id, 'consulta' => $consulta->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Veterinario Atendiendo *</label>
                            <select name="veterinario_id" class="form-control" required>
                                <option value="">Seleccione un veterinario...</option>
                                @foreach($veterinarios as $vet)
                                    <option value="{{ $vet->id }}" {{ (old('veterinario_id', $consulta->veterinario_id) == $vet->id) ? 'selected' : '' }}>
                                        {{ $vet->user->name }} - {{ $vet->especialidad ?? 'General' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('veterinario_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Fecha de la Consulta *</label>
                            <input type="datetime-local" class="form-control" name="fecha_consulta" value="{{ old('fecha_consulta', \Carbon\Carbon::parse($consulta->fecha_consulta)->format('Y-m-d\TH:i')) }}" required>
                            @error('fecha_consulta') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>

                <h6 class="font-weight-bold text-secondary mt-4 mb-3">Signos Vitales y Medidas</h6>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Peso (kg)</label>
                            <input type="number" step="0.01" class="form-control" name="peso" value="{{ old('peso', $consulta->peso) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Talla (cm)</label>
                            <input type="number" step="0.01" class="form-control" name="talla" value="{{ old('talla', $consulta->talla) }}">
                        </div>
                    </div>
                </div>

                <h6 class="font-weight-bold text-secondary mt-4 mb-3">Detalles Clínicos Iniciales</h6>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="font-weight-bold">Diagnóstico Presuntivo / Definitivo</label>
                            <textarea class="form-control" name="diagnostico" rows="4">{{ old('diagnostico', $consulta->diagnostico) }}</textarea>
                        </div>
                    </div>
                </div>

                <hr class="mt-4 mb-4">
                <div class="text-right">
                    <button type="submit" class="btn btn-primary shadow-sm"><i class="fas fa-save mr-1"></i> Actualizar Consulta</button>
                </div>
            </form>
        </div>
    </div>
@endsection
