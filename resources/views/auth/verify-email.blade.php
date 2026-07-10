<x-guest-layout>

<style>
    body{
        background: #1e2a5a;
    }

    .verify-wrapper{
        min-height: 100vh;
        display:flex;
        justify-content:center;
        align-items:center;
    }

    .verify-box{
        width: 550px;
        background:white;
        padding:40px;
        border-radius:20px;
        box-shadow:0 10px 30px rgba(0,0,0,0.3);
        text-align:center;
    }

    .verify-icon{
        font-size:70px;
        margin-bottom:15px;
    }

    .verify-title{
        font-size:28px;
        font-weight:bold;
        color:#1e2a5a;
        margin-bottom:15px;
    }

    .verify-text{
        color:#555;
        margin-bottom:30px;
        line-height:1.7;
    }

    .btn-custom{
        border-radius:30px;
        padding:12px;
        font-weight:bold;
    }

    .verify-footer{
        margin-top:20px;
        color:#777;
        font-size:14px;
    }
</style>

<div class="verify-wrapper">

    <div class="verify-box">

        <div class="verify-icon">
            📧
        </div>

        <div class="verify-title">
            Verifica tu correo
        </div>

        <div class="verify-text">
            Tu cuenta fue creada correctamente.<br><br>

            Hemos enviado un enlace de verificación a tu correo electrónico.<br>

            Debes verificar tu cuenta antes de iniciar sesión.
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success">
                Se envió un nuevo enlace de verificación a tu correo.
            </div>
        @endif

        <!-- Reenviar correo -->
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-custom">
                    🔄 Reenviar correo de verificación
                </button>
            </div>
        </form>

        <div class="verify-footer">
            Después de verificar tu correo puedes cerrar esta ventana e iniciar sesión.
        </div>

    </div>

</div>

</x-guest-layout>