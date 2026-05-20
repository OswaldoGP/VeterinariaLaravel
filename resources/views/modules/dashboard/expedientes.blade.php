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
                        <div class="col-md-8 position-relative">
                            <div class="input-group input-group-lg shadow-sm">
                                <input type="text" id="searchInput" class="form-control" placeholder="Buscar mascota por nombre, dueño o expediente..." aria-label="Buscar" autocomplete="off">
                            </div>
                            <!-- Contenedor de Resultados (Live Search) -->
                            <div id="searchResults" class="list-group position-absolute w-100 shadow" style="display: none; z-index: 1000; max-height: 300px; overflow-y: auto; left: 0; top: 100%; margin-top: 5px;">
                                <!-- Los resultados se inyectarán aquí mediante JS -->
                            </div>
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="row justify-content-center mb-3">
                        <div class="col-md-8 text-center">
                            <button type="button" id="btnVerConsultas" class="btn btn-info btn-icon-split mr-3 mb-2 shadow-sm" disabled>
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

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');
        let timeoutId;
        let selectedMascotaId = null;

        searchInput.addEventListener('input', function () {
            clearTimeout(timeoutId);
            selectedMascotaId = null;
            document.getElementById('btnVerConsultas').disabled = true;
            const query = this.value.trim();

            if (query.length === 0) {
                searchResults.style.display = 'none';
                searchResults.innerHTML = '';
                return;
            }

            // Añadir un pequeño retardo (debounce) para no saturar el servidor
            timeoutId = setTimeout(() => {
                fetch(`/expedientes/search?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        searchResults.innerHTML = '';
                        if (data.length > 0) {
                            data.forEach(mascota => {
                                const dueno = mascota.dueno ? mascota.dueno.nombre_completo : 'Sin dueño';
                                const a = document.createElement('a');
                                a.href = '#'; 
                                a.className = 'list-group-item list-group-item-action flex-column align-items-start';
                                a.dataset.id = mascota.id;
                                a.dataset.nombre = mascota.nombre;
                                a.innerHTML = `
                                    <div class="d-flex w-100 justify-content-between">
                                      <h5 class="mb-1 text-primary"><i class="fas fa-paw mr-2"></i>${mascota.nombre}</h5>
                                      <small class="text-muted">Folio: ${mascota.id}</small>
                                    </div>
                                    <p class="mb-1">Dueño: <strong>${dueno}</strong></p>
                                `;
                                a.addEventListener('click', function(e) {
                                    e.preventDefault();
                                    searchInput.value = this.dataset.nombre;
                                    selectedMascotaId = this.dataset.id;
                                    document.getElementById('btnVerConsultas').disabled = false;
                                    searchResults.style.display = 'none';
                                });
                                searchResults.appendChild(a);
                            });
                            searchResults.style.display = 'block';
                        } else {
                            searchResults.innerHTML = '<div class="list-group-item text-muted">No se encontraron expedientes.</div>';
                            searchResults.style.display = 'block';
                        }
                    })
                    .catch(error => console.error('Error en la búsqueda:', error));
            }, 300);
        });

        // Ocultar resultados si se hace click fuera
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.style.display = 'none';
            }
        });
        
        // Mostrar de nuevo al hacer focus si hay texto
        searchInput.addEventListener('focus', function() {
            if (this.value.trim().length > 0 && searchResults.innerHTML !== '' && !selectedMascotaId) {
                searchResults.style.display = 'block';
            }
        });

        // Botón Ver Consultas
        document.getElementById('btnVerConsultas').addEventListener('click', function() {
            if (selectedMascotaId) {
                window.location.href = `/expedientes/${selectedMascotaId}/consultas`;
            }
        });
    });
</script>
@endsection
