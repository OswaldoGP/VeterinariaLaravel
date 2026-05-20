@extends('layouts.main')

@section('title', 'Diagnóstico - ' . $mascota->nombre)

@section('styles')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Diagnóstico</h1>
    </div>

    <!-- Breadcrumb -->
    <div class="card shadow-sm mb-4">
        <div class="card-body py-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('expedientes.index') }}">Expedientes</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('expedientes.consultas', $mascota->id) }}">{{ $mascota->nombre }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('expedientes.consultas.show', [$mascota->id, $consulta->id]) }}">Consulta #{{ $consulta->id }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Diagnóstico</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Tarjeta de Información de Mascota y Consulta -->
    <div class="card border-left-primary shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <!-- Info de mascota -->
                <div class="col-md-8 d-flex align-items-center">
                    <div class="mr-4">
                        <i class="fas fa-paw fa-3x text-primary opacity-50"></i>
                    </div>
                    <div>
                        <h4 class="font-weight-bold text-gray-800 mb-1">{{ $mascota->nombre }}</h4>
                        <div class="text-muted small">
                            Folio #{{ $mascota->id }} &bull; 
                            {{ $mascota->especie }} / {{ $mascota->raza ?? 'Sin especificar' }}
                        </div>
                    </div>
                </div>
                <!-- Botón o Badge de Fecha -->
                <div class="col-md-4 text-md-right mt-3 mt-md-0">
                    <button class="btn btn-primary btn-sm shadow-sm" style="pointer-events: none;">
                        <i class="fas fa-calendar-alt fa-sm text-white-50"></i> Consulta del {{ $consulta->fecha_consulta->format('d/m/Y') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Alertas de Éxito -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Tarjeta de Edición de Diagnóstico -->
    <div class="card shadow-sm mb-4">
        <div class="card-header py-3 bg-white border-bottom-0 pt-4 pb-0">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-clipboard-list mr-2"></i>Diagnóstico de la Consulta
            </h6>
        </div>
        <div class="card-body pt-3">
            <form id="diagnosticoForm" action="{{ route('expedientes.consultas.diagnostico.update', [$mascota->id, $consulta->id]) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group mb-4">
                    <input type="hidden" name="diagnostico" id="diagnostico">
                    <div id="editor-container" style="height: 300px;">{!! old('diagnostico', $consulta->diagnostico) !!}</div>
                </div>
                
                <div class="text-right">
                    <button type="submit" class="btn btn-primary px-4 shadow-sm">
                        <i class="fas fa-save mr-2"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var quill = new Quill('#editor-container', {
                theme: 'snow',
                placeholder: 'Aún sin diagnóstico...'
            });

            var form = document.getElementById('diagnosticoForm');
            form.onsubmit = function() {
                var html = quill.root.innerHTML;
                if (html === '<p><br></p>') {
                    html = '';
                }
                document.getElementById('diagnostico').value = html;
            };
        });
    </script>
@endsection
