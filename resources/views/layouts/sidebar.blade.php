
<div class="sidebar">

    {{-- LOGO --}}
    <div class="logo-area">
        <div class="d-flex align-items-center gap-3">
            <div class="logo-icon">
                <img src="{{ asset('img/logoinicio1.jpg') }}" alt="Logo I.E">
            </div>
            <div>
                <h5>Inventario</h5>
                <small>Sistema Web</small>
            </div>
        </div>
    </div>

    {{-- PRINCIPAL --}}
    @if(in_array(auth()->user()->rol, ['administrador', 'directiva']))
    <div class="menu-section">
        <p class="menu-title">PRINCIPAL</p>
        <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-fill"></i>
            Dashboard
        </a>
    </div>
    @endif

    {{-- INVENTARIO --}}
    @if(in_array(auth()->user()->rol, ['administrador', 'directiva', 'mantenimiento']))
    <div class="menu-section">
        <p class="menu-title">INVENTARIO</p>
        <a href="{{ route('equipos.index') }}" class="menu-item {{ request()->routeIs('equipos.*') ? 'active' : '' }}">
            <i class="bi bi-laptop"></i>
            Equipos
        </a>

        {{-- SOLO ADMIN --}}
        @if(auth()->user()->rol == 'administrador')
        <a href="{{ route('proveedores.index') }}" class="menu-item {{ request()->routeIs('proveedores.*') ? 'active' : '' }}">
            <i class="bi bi-truck"></i>
            Proveedores
        </a>
        <a href="{{ route('categorias.index') }}" class="menu-item {{ request()->routeIs('categorias.*') ? 'active' : '' }}">
            <i class="bi bi-folder"></i>
            Categorías
        </a>
        @endif
    </div>
    @endif

    {{-- GESTION --}}
    @if(in_array(auth()->user()->rol, ['administrador', 'directiva']))
    <div class="menu-section">
        <p class="menu-title">GESTIÓN</p>

        {{-- SOLO ADMIN --}}
        @if(auth()->user()->rol == 'administrador')
        <a href="{{ route('movimientos.index') }}" class="menu-item {{ request()->routeIs('movimientos.*') ? 'active' : '' }}">
            <i class="bi bi-clock-history"></i>
            Movimientos
        </a>
        @endif

        <a href="{{ route('prestamos.index') }}" class="menu-item {{ request()->routeIs('prestamos.*') ? 'active' : '' }}">
            <i class="bi bi-box-arrow-up"></i>
            Préstamos
        </a>

        <a href="{{ route('reportes.index') }}" class="menu-item {{ request()->routeIs('reportes.*') ? 'active' : '' }}">
            <i class="bi bi-bar-chart-fill"></i>
            Reportes
        </a>
    </div>
    @endif

    {{-- SISTEMA --}}
    @if(in_array(auth()->user()->rol, ['administrador', 'mantenimiento']))
    <div class="menu-section">
        <p class="menu-title">SISTEMA</p>

        {{-- SOLO ADMIN --}}
        @if(auth()->user()->rol == 'administrador')
        <a href="{{ route('chatbot.index') }}" class="menu-item {{ request()->routeIs('chatbot.*') ? 'active' : '' }}">
            <i class="bi bi-robot"></i>
            Chat IA
        </a>
        @endif

        <a href="{{ route('diagnosticos.index') }}" class="menu-item {{ request()->routeIs('diagnosticos.*') ? 'active' : '' }}">
            <i class="bi bi-clipboard-data"></i>
            Diagnósticos
        </a>

        {{-- SOLO ADMIN --}}
        @if(auth()->user()->rol == 'administrador')
        <a href="{{ route('configuracion.index') }}" class="menu-item {{ request()->routeIs('configuracion.*') ? 'active' : '' }}">
            <i class="bi bi-gear-fill"></i>
            Configuración
        </a>
        @endif
    </div>
    @endif

    {{-- SEGURIDAD (MÓDULO DE USUARIOS) --}}
    @if(auth()->user()->rol == 'administrador')
    <div class="menu-section">
        <p class="menu-title">SEGURIDAD</p>
        <a href="{{ route('usuarios.index') }}" class="menu-item {{ request()->routeIs('usuarios.*') ? 'active' : '' }}">
            <i class="bi bi-person-check-fill"></i>
            Usuarios y Roles
        </a>
    </div>
    @endif

    {{-- USUARIO --}}
    <div class="sidebar-user">
        <div class="user-avatar">
            <i class="bi bi-person-fill"></i>
        </div>

        <div class="user-details">
            <div class="user-role">
                {{ ucfirst(auth()->user()->rol) }}
            </div>

            <div class="user-name">
                {{ auth()->user()->name }}
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="logout-btn-sidebar">
                    <i class="bi bi-box-arrow-right"></i>
                    Cerrar sesión
                </button>
            </form>
        </div>
    </div>

</div>