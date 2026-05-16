<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-paw"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Veterinaria</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ url('/') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Gestión
    </div>

    <!-- Nav Item - Mascotas -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMascotas"
            aria-expanded="true" aria-controls="collapseMascotas">
            <i class="fas fa-fw fa-dog"></i>
            <span>Mascotas</span>
        </a>
        <div id="collapseMascotas" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="#">Lista de Mascotas</a>
                <a class="collapse-item" href="#">Agregar Mascota</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Clientes -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseClientes"
            aria-expanded="true" aria-controls="collapseClientes">
            <i class="fas fa-fw fa-users"></i>
            <span>Clientes</span>
        </a>
        <div id="collapseClientes" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="#">Lista de Clientes</a>
                <a class="collapse-item" href="#">Agregar Cliente</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    @if(auth()->check() && auth()->user()->rol === 'administrador')
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Administración
    </div>

    <!-- Nav Item - Usuarios -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsuarios"
            aria-expanded="true" aria-controls="collapseUsuarios">
            <i class="fas fa-fw fa-user-cog"></i>
            <span>Usuarios</span>
        </a>
        <div id="collapseUsuarios" class="collapse" aria-labelledby="headingUsuarios"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('admin.users.index') }}">Lista de Usuarios</a>
                <a class="collapse-item" href="{{ route('admin.users.create') }}">Agregar Usuario</a>
            </div>
        </div>
    </li>
    @endif

    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
