@extends('layouts.admin')

@section('title', 'Acerca de')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Acerca de la Empresa</h1>
    </div>

    <!-- Content Row -->
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Información de Contacto</h6>
                </div>
                <div class="card-body text-center pt-5 pb-5">
                    <!-- Logo Circular -->
                    <div class="mb-4">
                        <img src="{{ asset('img/vet.jpeg') }}" alt="Logo Veternova" class="rounded-logo" style="width: 200px; height: 200px; object-fit: cover;">
                    </div>
                    
                    <!-- Nombre de la Empresa -->
                    <h2 class="font-weight-bold mb-4" style="color: var(--primary);">Veternova</h2>
                    
                    <!-- Datos de la empresa -->
                    <div class="row justify-content-center">
                        <div class="col-md-8 text-left">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex align-items-center p-3">
                                    <i class="fas fa-map-marker-alt fa-fw text-primary mr-3 fa-lg"></i>
                                    <div>
                                        <strong>Dirección:</strong><br>
                                        <span class="text-muted">Bugambilia 7 / Tepito / CDMX</span>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex align-items-center p-3">
                                    <i class="fas fa-phone-alt fa-fw text-primary mr-3 fa-lg"></i>
                                    <div>
                                        <strong>Teléfono:</strong><br>
                                        <span class="text-muted">565 216 797</span>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex align-items-center p-3">
                                    <i class="fas fa-envelope fa-fw text-primary mr-3 fa-lg"></i>
                                    <div>
                                        <strong>Correo Electrónico:</strong><br>
                                        <a href="mailto:chakal69@gmail.com" class="text-muted">chakal69@gmail.com</a>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex align-items-center p-3">
                                    <i class="fab fa-facebook fa-fw text-primary mr-3 fa-lg"></i>
                                    <div>
                                        <strong>Redes Sociales:</strong><br>
                                        <a href="#" class="text-muted">Facebook: Veternova</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <hr class="mt-5 mb-4">
                    <p class="text-muted small mb-0">Sistema de Gestión Veterinaria &copy; 2026. Todos los derechos reservados.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
