<x-guest-layout>
    
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">

<div class="reset-wrapper">

    <div class="reset-card">

        <h2 class="reset-title">
            🔑 Recuperar Contraseña
        </h2>

        <p class="reset-description">
            Ingresa tu correo electrónico y te enviaremos
            un enlace para restablecer tu contraseña.
        </p>

        @if (session('status'))

            <div class="alert alert-success">

                {{ session('status') }}

            </div>

        @endif

        <form method="POST" action="{{ route('password.email') }}">

            @csrf

            <div class="mb-4">

                <label class="form-label fw-semibold">
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

                    <div class="text-danger mt-1">

                        {{ $message }}

                    </div>

                @enderror

            </div>

            <div class="d-grid">

                <button
                    type="submit"
                    class="btn btn-reset">

                    Enviar enlace de recuperación

                </button>

            </div>

        </form>

        <div class="text-center mt-4">

            <a
                href="{{ route('login') }}"
                class="back-link">

                ← Volver al inicio de sesión

            </a>

        </div>

    </div>

</div>

</x-guest-layout>