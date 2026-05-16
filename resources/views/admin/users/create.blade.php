@extends('layouts.admin')

@section('title', 'Agregar Usuario')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Agregar Usuario</h1>
        <a href="{{ route('admin.users.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i
                class="fas fa-arrow-left fa-sm text-white-50"></i> Volver</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Datos del Usuario</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="name">Nombre</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}" required>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" name="password" class="form-control" id="password" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="rol">Rol</label>
                        <select name="rol" class="form-control" id="rol" required onchange="toggleVetFields()">
                            <option value="">Seleccione un rol...</option>
                            <option value="administrador" {{ old('rol') == 'administrador' ? 'selected' : '' }}>Administrador</option>
                            <option value="veterinario" {{ old('rol') == 'veterinario' ? 'selected' : '' }}>Veterinario</option>
                        </select>
                    </div>
                </div>

                <!-- Campos adicionales para Veterinario -->
                <div id="vet_fields" style="display: {{ old('rol') == 'veterinario' ? 'block' : 'none' }};">
                    <hr>
                    <h6 class="font-weight-bold text-info mb-3">Información del Veterinario</h6>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="especialidad">Especialidad</label>
                            <input type="text" name="especialidad" class="form-control" id="especialidad" value="{{ old('especialidad') }}">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="text" name="telefono" class="form-control" id="telefono" value="{{ old('telefono') }}">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="cedula_profesional">Cédula Profesional</label>
                            <input type="text" name="cedula_profesional" class="form-control" id="cedula_profesional" value="{{ old('cedula_profesional') }}">
                        </div>
                    </div>
                </div>
                
                <div class="text-right mt-3">
                    <button type="submit" class="btn btn-primary px-5">Guardar Usuario</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function toggleVetFields() {
        var rol = document.getElementById('rol').value;
        var vetFields = document.getElementById('vet_fields');
        if (rol === 'veterinario') {
            vetFields.style.display = 'block';
        } else {
            vetFields.style.display = 'none';
        }
    }

    // Call on load in case of validation error to restore state
    document.addEventListener('DOMContentLoaded', function() {
        toggleVetFields();
    });
</script>
@endsection
