@extends(Auth::user()->rol === 'administrador' ? 'layouts.admin' : 'layouts.main')

@section('title', 'Mi Perfil')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Mi Perfil</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <!-- Tarjeta de Perfil Izquierda -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 text-center">
                    <h6 class="m-0 font-weight-bold text-primary">Fotografía de Perfil</h6>
                </div>
                <div class="card-body text-center">
                    <div class="mb-4">
                        <img class="rounded-circle img-fluid" style="width: 150px; height: 150px; object-fit: cover; border: 4px solid var(--primary-light); box-shadow: 0 4px 8px rgba(0,0,0,0.1);" 
                             src="{{ $user->foto_perfil ? asset('storage/' . $user->foto_perfil) : (Auth::user()->rol === 'administrador' ? asset('Plantilla7u7/img/undraw_profile_3.svg') : asset('Plantilla7u7/img/undraw_profile.svg')) }}" 
                             alt="Foto de Perfil" id="preview-image">
                    </div>
                    <h4 class="font-weight-bold mb-1">{{ $user->name }}</h4>
                    <p class="text-muted mb-4">{{ ucfirst($user->rol) }} {{ $user->rol === 'veterinario' && $user->veterinario ? '- ' . $user->veterinario->especialidad : '' }}</p>
                    
                    <form action="{{ route('perfil.update') }}" method="POST" enctype="multipart/form-data" id="photoForm">
                        @csrf
                        @method('PUT')
                        <div class="form-group text-left">
                            <label for="foto_perfil" class="small font-weight-bold text-primary">Actualizar fotografía</label>
                            <input type="file" class="form-control-file border p-2 rounded" id="foto_perfil" name="foto_perfil" accept="image/png, image/jpeg, image/jpg, image/gif" onchange="previewImage(this); document.getElementById('photoForm').submit();">
                            @error('foto_perfil')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <small class="text-muted d-block mt-2">La imagen se guardará automáticamente al seleccionarla.</small>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Formulario de Información Derecha -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Información de Contacto y Personal</h6>
                </div>
                <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Nombre Completo</label>
                                    <input type="text" class="form-control bg-light" value="{{ $user->name }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Correo Electrónico</label>
                                    <input type="email" class="form-control bg-light" value="{{ $user->email }}" readonly>
                                </div>
                            </div>
                        </div>

                        @if($user->rol === 'veterinario')
                            <hr class="mt-4 mb-4">
                            <h6 class="font-weight-bold text-primary mb-3">Datos Profesionales</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Especialidad</label>
                                        <input type="text" class="form-control bg-light" value="{{ $user->veterinario->especialidad ?? 'Sin especificar' }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Cédula Profesional</label>
                                        <input type="text" class="form-control bg-light" value="{{ $user->veterinario->cedula ?? 'Sin especificar' }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Teléfono de Contacto</label>
                                        <input type="text" class="form-control bg-light" value="{{ $user->veterinario->telefono ?? 'Sin especificar' }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <hr class="mt-4 mb-4">
                            <div class="alert alert-info border-left-info shadow-sm">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-info-circle fa-2x mr-3 text-info"></i>
                                    <div>
                                        <p class="mb-1"><strong>¿Necesitas actualizar tus datos?</strong></p>
                                        <p class="mb-0 small">Por motivos de seguridad y consistencia, la modificación de tus datos personales y profesionales es gestionada exclusivamente por el administrador del sistema.</p>
                                    </div>
                                </div>
                                <div class="mt-3 text-right">
                                    <a href="mailto:admin@veternova.com?subject=Solicitud de Actualización de Datos - {{ $user->name }}" class="btn btn-sm btn-info shadow-sm">
                                        <i class="fas fa-envelope mr-1"></i> Solicitar Actualización al Admin
                                    </a>
                                </div>
                            </div>
                        @else
                            <hr class="mt-4 mb-4">
                            <p class="text-muted small mb-0"><i class="fas fa-info-circle mr-1"></i> La gestión avanzada de datos de usuario se realiza desde el panel global de Usuarios.</p>
                        @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                document.getElementById('preview-image').setAttribute('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
