<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-paw"></i>
        </div>
        <div class="sidebar-brand-text mx-3">VETERINARIA</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Heading -->
    <div class="sidebar-heading mt-3">
        Consulta
    </div>

    <!-- Nav Item - Diagnóstico -->
    <li class="nav-item {{ request()->routeIs('expedientes.consultas.diagnostico') ? 'active' : '' }}">
        <a class="nav-link pt-2 pb-2" href="{{ isset($mascota) && isset($consulta) ? route('expedientes.consultas.diagnostico', [$mascota->id, $consulta->id]) : '#' }}">
            <i class="fas fa-fw fa-file-medical-alt"></i>
            <span>Diagnóstico</span>
        </a>
    </li>

    <!-- Nav Item - Tratamiento -->
    <li class="nav-item {{ request()->routeIs('expedientes.consultas.tratamiento') ? 'active' : '' }}">
        <a class="nav-link pt-2 pb-2" href="{{ isset($mascota) && isset($consulta) ? route('expedientes.consultas.tratamiento', [$mascota->id, $consulta->id]) : '#' }}">
            <i class="fas fa-fw fa-pills"></i>
            <span>Tratamiento</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider mt-2 mb-2">

    <!-- Heading -->
    <div class="sidebar-heading">
        Antecedentes
    </div>

    <!-- Nav Item - Alergias -->
    <li class="nav-item {{ request()->routeIs('expedientes.mascota.alergias') ? 'active' : '' }}">
        <a class="nav-link pt-2 pb-2" href="{{ isset($mascota) ? route('expedientes.mascota.alergias', $mascota->id) : '#' }}">
            <i class="fas fa-fw fa-hand-paper"></i>
            <span>Alergias</span>
        </a>
    </li>

    <!-- Nav Item - Lesiones -->
    <li class="nav-item {{ request()->routeIs('expedientes.mascota.lesiones') ? 'active' : '' }}">
        <a class="nav-link pt-2 pb-2" href="{{ isset($mascota) ? route('expedientes.mascota.lesiones', $mascota->id) : '#' }}">
            <i class="fas fa-fw fa-bone"></i>
            <span>Lesiones</span>
        </a>
    </li>

    <!-- Nav Item - Patológicos -->
    <li class="nav-item {{ request()->routeIs('expedientes.mascota.patologias') ? 'active' : '' }}">
        <a class="nav-link pt-2 pb-2" href="{{ isset($mascota) ? route('expedientes.mascota.patologias', $mascota->id) : '#' }}">
            <i class="fas fa-fw fa-heartbeat"></i>
            <span>Patológicos</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider mt-2 mb-2">

    <!-- Heading -->
    <div class="sidebar-heading">
        Historial
    </div>

    <!-- Nav Item - Alimentación -->
    <li class="nav-item {{ request()->routeIs('expedientes.mascota.alimentacion') ? 'active' : '' }}">
        <a class="nav-link pt-2 pb-2" href="{{ isset($mascota) ? route('expedientes.mascota.alimentacion', $mascota->id) : '#' }}">
            <i class="fas fa-fw fa-utensils"></i>
            <span>Alimentación</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block mt-3">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
