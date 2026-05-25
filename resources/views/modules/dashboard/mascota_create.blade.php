@extends('layouts.main')

@section('title', 'Nuevo Paciente / Mascota')

@section('hide_sidebar', true)

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Registrar Nuevo Paciente</h1>
        <a href="{{ route('expedientes.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver a Expedientes
        </a>
    </div>

    <div class="row">
        <div class="col-xl-8 col-lg-10 mx-auto">
            <div class="card shadow mb-4 border-left-success">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">Formulario de Registro Completo</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('expedientes.store') }}" method="POST">
                        @csrf
                        
                        <!-- Sección: Datos del Dueño -->
                        <h5 class="font-weight-bold text-primary mb-3"><i class="fas fa-user mr-2"></i>Datos del Dueño</h5>
                        <div class="row bg-light p-3 rounded mb-4 mx-0 border">
                            <div class="col-md-6 mb-3">
                                <label for="dueno_nombre" class="font-weight-bold">Nombre Completo *</label>
                                <input type="text" class="form-control" id="dueno_nombre" name="dueno_nombre" value="{{ old('dueno_nombre') }}" placeholder="Ej. Juan Pérez" required>
                                @error('dueno_nombre') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="dueno_telefono" class="font-weight-bold">Teléfono de Contacto</label>
                                <input type="text" class="form-control" id="dueno_telefono" name="dueno_telefono" value="{{ old('dueno_telefono') }}" placeholder="Ej. 555-123-4567">
                                @error('dueno_telefono') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="dueno_direccion" class="font-weight-bold">Dirección Completa</label>
                                <input type="text" class="form-control" id="dueno_direccion" name="dueno_direccion" value="{{ old('dueno_direccion') }}" placeholder="Calle, Número, Colonia, Ciudad">
                                @error('dueno_direccion') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <!-- Sección: Datos del Paciente / Mascota -->
                        <h5 class="font-weight-bold text-success mb-3"><i class="fas fa-paw mr-2"></i>Datos del Paciente (Mascota)</h5>
                        <div class="row bg-light p-3 rounded mb-4 mx-0 border">
                            <div class="col-md-6 mb-3">
                                <label for="mascota_nombre" class="font-weight-bold">Nombre de la Mascota *</label>
                                <input type="text" class="form-control" id="mascota_nombre" name="mascota_nombre" value="{{ old('mascota_nombre') }}" placeholder="Ej. Firulais" required>
                                @error('mascota_nombre') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="mascota_especie" class="font-weight-bold">Especie *</label>
                                <input type="text" class="form-control" id="mascota_especie" name="mascota_especie" value="{{ old('mascota_especie') }}" placeholder="Ej. Perro, Gato, Ave..." required>
                                @error('mascota_especie') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="mascota_raza" class="font-weight-bold">Raza</label>
                                <input type="text" class="form-control" id="mascota_raza" name="mascota_raza" value="{{ old('mascota_raza') }}" placeholder="Ej. Labrador, Siamés...">
                                @error('mascota_raza') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="mascota_fecha_nacimiento" class="font-weight-bold">Fecha de Nacimiento (Aprox.)</label>
                                <input type="date" class="form-control" id="mascota_fecha_nacimiento" name="mascota_fecha_nacimiento" value="{{ old('mascota_fecha_nacimiento') }}">
                                @error('mascota_fecha_nacimiento') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="mascota_tipo_sangre" class="font-weight-bold">Tipo de Sangre</label>
                                <input type="text" class="form-control" id="mascota_tipo_sangre" name="mascota_tipo_sangre" value="{{ old('mascota_tipo_sangre') }}" placeholder="Ej. DEA 1.1 Positivo">
                                @error('mascota_tipo_sangre') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="mascota_comportamiento" class="font-weight-bold">Comportamiento</label>
                                <input type="text" class="form-control" id="mascota_comportamiento" name="mascota_comportamiento" value="{{ old('mascota_comportamiento') }}" placeholder="Ej. Tranquilo y amigable">
                                @error('mascota_comportamiento') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-12 mt-2">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="mascota_es_adoptado" name="mascota_es_adoptado" value="1" {{ old('mascota_es_adoptado') ? 'checked' : '' }}>
                                    <label class="custom-control-label font-weight-bold text-info" for="mascota_es_adoptado">¿La mascota es adoptada?</label>
                                </div>
                                @error('mascota_es_adoptado') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <hr class="mt-4 mb-4">
                        <div class="text-right">
                            <a href="{{ route('expedientes.index') }}" class="btn btn-secondary shadow-sm mr-2">Cancelar</a>
                            <button type="submit" class="btn btn-success shadow-sm">
                                <i class="fas fa-save mr-1"></i> Guardar Expediente
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
