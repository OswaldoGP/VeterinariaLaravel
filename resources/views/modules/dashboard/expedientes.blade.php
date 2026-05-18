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
                    <p>Aquí podrás gestionar los expedientes de las mascotas.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
