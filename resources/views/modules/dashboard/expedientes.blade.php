@extends('layouts.main')

@section('hide_sidebar', true)

@section('title', 'Expedientes')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Expedientes</h1>
        <a href="{{ route('home') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver al Dashboard
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Gestión de Expedientes</h6>
                </div>
                <div class="card-body">
                    <!-- Buscador -->
                    <div class="row justify-content-center mb-4 mt-3">
                        <div class="col-md-8">
                            <div class="input-group input-group-lg shadow-sm">
                                <input type="text" class="form-control" placeholder="Buscar mascota por nombre, dueño o expediente..." aria-label="Buscar" aria-describedby="button-search">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" id="button-search">
                                        <i class="fas fa-search"></i> Buscar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="row justify-content-center mb-3">
                        <div class="col-md-8 text-center">
                            <button type="button" class="btn btn-info btn-icon-split mr-3 mb-2 shadow-sm">
                                <span class="icon text-white-50">
                                    <i class="fas fa-file-medical-alt"></i>
                                </span>
                                <span class="text">Ver Consultas</span>
                            </button>
                            
                            <button type="button" class="btn btn-success btn-icon-split mb-2 shadow-sm">
                                <span class="icon text-white-50">
                                    <i class="fas fa-paw"></i>
                                </span>
                                <span class="text">Nuevo Paciente / Mascota</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
