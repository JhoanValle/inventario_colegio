<x-guest-layout>
    
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">

<div class="login-wrapper">

    <div class="login-box">

        {{-- IZQUIERDA --}}
        <div class="login-left">

            <h3 class="login-title">
                🔐 Iniciar Sesión
            </h3>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- EMAIL --}}
                <div class="mb-3">

                    <label class="form-label">
                        Correo electrónico
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            📧
                        </span>

                        <input
                            id="email"
                            type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus>

                    </div>

                    @error('email')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

                {{-- PASSWORD --}}
                <div class="mb-3">

                    <label class="form-label">
                        Contraseña
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            🔒
                        </span>

                        <input
                            id="password"
                            type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            name="password"
                            required>

                        <button
                            type="button"
                            class="input-group-text"
                            id="togglePassword"
                            style="cursor:pointer;">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>

                    @error('password')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

                {{-- RECORDAR --}}
                <div class="mb-3 form-check">

                    <input
                        type="checkbox"
                        class="form-check-input"
                        name="remember"
                        id="remember">

                    <label
                        class="form-check-label"
                        for="remember">

                        Recordarme

                    </label>

                </div>

                {{-- BOTON LOGIN --}}
                <div class="d-grid">

                    <button
                        type="submit"
                        class="btn btn-login">

                        Iniciar Sesión

                    </button>

                </div>

                {{-- REGISTRO --}}
                <div class="text-center mt-3">

                    <a href="{{ route('register') }}"
                       class="btn btn-outline-primary w-100">

                        📝 Crear cuenta nueva

                    </a>

                </div>

                {{-- RECUPERAR --}}
                @if(Route::has('password.request'))

                    <div class="text-center mt-3">

                        <a href="{{ route('password.request') }}">

                            ¿Olvidaste tu contraseña?

                        </a>

                    </div>

                @endif

            </form>

        </div>

        {{-- DERECHA --}}
        <div class="login-right">

            <div class="overlay-title">
                Bienvenido 👋
            </div>

            <div class="overlay-subtitle">
                Sistema Web de Inventario Tecnológico
            </div>

            <img
                src="{{ asset('img/logoinicio1.jpg') }}"
                alt="Logo">
        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const password = document.getElementById('password');
    const toggle = document.getElementById('togglePassword');
    const icon = toggle.querySelector('i');

    toggle.addEventListener('click', function () {

        if (password.type === 'password') {
            password.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            password.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }

    });

});
</script>

</x-guest-layout>