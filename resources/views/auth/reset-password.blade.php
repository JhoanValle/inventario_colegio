<x-guest-layout>
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow p-4" style="width: 400px; border-radius: 12px;">
        <h3 class="text-center mb-4">🔒 Restablecer Contraseña</h3>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input id="email" type="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       name="email" 
                       value="{{ old('email', $request->email) }}" 
                       required autofocus autocomplete="username">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            
            <div class="mb-3">
                <label for="password" class="form-label">Nueva contraseña</label>
                <input id="password" type="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       name="password" 
                       required autocomplete="new-password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
                <input id="password_confirmation" type="password" 
                       class="form-control @error('password_confirmation') is-invalid @enderror" 
                       name="password_confirmation" 
                       required autocomplete="new-password">
                @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            
            <div class="d-grid mt-3">
                <button type="submit" class="btn btn-primary">
                    Restablecer Contraseña
                </button>
            </div>
        </form>

        <div class="text-center mt-3">
            <a href="{{ route('login') }}">Volver al inicio de sesión</a>
        </div>
    </div>
</div>
</x-guest-layout>