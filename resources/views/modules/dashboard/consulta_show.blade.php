@extends('layouts.main')

@section('title', 'Detalle de Consulta - ' . $mascota->nombre)

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detalle de Consulta</h1>
    </div>

    <!-- Breadcrumb -->
    <div class="card shadow-sm mb-4">
        <div class="card-body py-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('expedientes.index') }}">Expedientes</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('expedientes.consultas', $mascota->id) }}">{{ $mascota->nombre }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Consulta #{{ $consulta->id }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Tarjeta Principal (Paciente y Dueño) -->
    <div class="card border-left-primary shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8 d-flex align-items-center">
                    <div class="mr-4">
                        <i class="fas fa-paw fa-3x text-primary opacity-50"></i>
                    </div>
                    <div>
                        <h4 class="font-weight-bold text-gray-800 mb-1">{{ $mascota->nombre }}</h4>
                        <div class="text-muted small">
                            Folio #{{ $mascota->id }} &bull; 
                            {{ $mascota->especie }} / {{ $mascota->raza }} &bull; 
                            Tipo de sangre: {{ $mascota->tipo_sangre ?? 'N/A' }}
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-right border-left mt-3 mt-md-0">
                    <div class="text-xs font-weight-bold text-muted text-uppercase mb-1">Dueño</div>
                    <div class="h6 mb-1 font-weight-bold text-gray-800">
                        <i class="fas fa-user text-gray-400 mr-1"></i> {{ $mascota->dueno->nombre_completo ?? 'Sin dueño' }}
                    </div>
                    @if($mascota->dueno && $mascota->dueno->telefono)
                        <div class="small text-muted">
                            <i class="fas fa-phone-alt text-gray-400 mr-1"></i> {{ $mascota->dueno->telefono }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido Inferior (Consulta y Datos) -->
    <div class="row">
        <!-- Detalles de Consulta (Izquierda) -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white border-bottom-0 pt-4 pb-0">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-stethoscope mr-2"></i>Consulta #{{ $consulta->id }}
                    </h6>
                    <span class="badge badge-primary px-3 py-2" style="font-size: 0.9rem;">
                        {{ $consulta->fecha_consulta->format('d/m/Y H:i') }}
                    </span>
                </div>
                <div class="card-body pt-4">
                    <!-- Tarjetas de datos rápidos -->
                    <div class="row text-center mb-4">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <div class="border rounded py-3 h-100">
                                <div class="text-xs font-weight-bold text-muted text-uppercase mb-2">Veterinario</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <i class="fas fa-user-md text-info mr-2"></i>{{ $consulta->veterinario->user->name ?? 'N/A' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <div class="border rounded py-3 h-100">
                                <div class="text-xs font-weight-bold text-muted text-uppercase mb-2">Peso</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $consulta->peso ? $consulta->peso . ' kg' : '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border rounded py-3 h-100">
                                <div class="text-xs font-weight-bold text-muted text-uppercase mb-2">Talla</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $consulta->talla ? $consulta->talla . ' cm' : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Diagnóstico -->
                    <div class="mt-4">
                        <h6 class="font-weight-bold text-gray-800 border-bottom pb-2 mb-3">
                            <i class="fas fa-file-medical text-primary mr-2"></i>Diagnóstico
                        </h6>
                        <div class="p-3 bg-light border rounded text-gray-800" style="min-height: 100px;">
                            @if($consulta->diagnostico)
                                {!! nl2br(e($consulta->diagnostico)) !!}
                            @else
                                <span class="text-muted fst-italic">No hay diagnóstico registrado para esta consulta.</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Datos del Paciente (Derecha) -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3 bg-white border-bottom-0 pt-4 pb-0">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-info-circle mr-2"></i>Datos del Paciente
                    </h6>
                </div>
                <div class="card-body pt-4">
                    <div class="mb-4">
                        <div class="text-xs font-weight-bold text-muted text-uppercase mb-1">Fecha de Nacimiento</div>
                        <div class="text-gray-800">{{ $mascota->fecha_nacimiento ? \Carbon\Carbon::parse($mascota->fecha_nacimiento)->format('d/m/Y') : 'N/A' }}</div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="text-xs font-weight-bold text-muted text-uppercase mb-1">Tipo de Sangre</div>
                        <div class="text-gray-800">{{ $mascota->tipo_sangre ?? 'N/A' }}</div>
                    </div>

                    <div class="mb-4">
                        <div class="text-xs font-weight-bold text-muted text-uppercase mb-1">Comportamiento</div>
                        <div class="text-gray-800">{{ $mascota->comportamiento ?? 'N/A' }}</div>
                    </div>

                    <div>
                        <div class="text-xs font-weight-bold text-muted text-uppercase mb-2">Adoptado</div>
                        @if($mascota->es_adoptado)
                            <span class="badge badge-success px-3 py-1">Sí</span>
                        @else
                            <span class="badge badge-secondary px-3 py-1">No</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
