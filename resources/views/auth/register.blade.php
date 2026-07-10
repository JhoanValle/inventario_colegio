<style>

    body{
        margin: 0;
        padding: 0;
        background: #1e2a5a;
        font-family: 'Segoe UI', sans-serif;
    }

    .register-wrapper{
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 30px;
    }

    .register-box{
        width: 950px;
        background: white;
        border-radius: 20px;
        overflow: hidden;
        display: flex;
        box-shadow: 0 15px 40px rgba(0,0,0,0.25);
    }

    
    .register-left{
        width: 45%;
        padding: 45px;
    }

    .register-title{
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 8px;
        color: #1e293b;
    }

    .register-subtitle{
        color: #64748b;
        margin-bottom: 30px;
    }

    .form-group{
        margin-bottom: 18px;
    }

    .form-label{
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #334155;
    }

    .form-control{
        width: 100%;
        padding: 14px 16px;
        border-radius: 14px;
        border: 1px solid #cbd5e1;
        outline: none;
        font-size: 15px;
        transition: .3s;
        box-sizing: border-box;
    }

    .form-control:focus{
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59,130,246,.15);
    }

    .btn-register{
        width: 100%;
        border: none;
        padding: 14px;
        border-radius: 14px;
        background: linear-gradient(135deg,#2563eb,#06b6d4);
        color: white;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: .3s;
    }

    .btn-register:hover{
        transform: translateY(-2px);
        opacity: .95;
    }

    .btn-login{
        display: block;
        width: 100%;
        text-align: center;
        padding: 13px;
        border-radius: 14px;
        border: 1px solid #cbd5e1;
        text-decoration: none;
        color: #334155;
        margin-top: 15px;
        transition: .3s;
        box-sizing: border-box;
    }

    .btn-login:hover{
        background: #f8fafc;
    }

    
    .register-right{
        width: 55%;
        background: linear-gradient(135deg,#3b82f6,#06b6d4);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        position: relative;
        padding: 30px;
    }

    .register-right img{
        width: 250px;
        max-width: 100%;
        border-radius: 12px;
        background: white;
        padding: 10px;
    }

    .overlay-text{
        position: absolute;
        top: 40px;
        text-align: center;
        color: white;
    }

    .overlay-text h2{
        margin: 0;
        font-size: 38px;
        font-weight: bold;
    }

    .overlay-text p{
        margin-top: 10px;
        font-size: 16px;
        opacity: .9;
    }

    .alert{
        background: #fee2e2;
        color: #991b1b;
        padding: 12px;
        border-radius: 12px;
        margin-bottom: 20px;
    }

    .alert ul{
        margin: 0;
        padding-left: 20px;
    }

    
    @media(max-width: 900px){

        .register-box{
            flex-direction: column;
            width: 100%;
        }

        .register-left,
        .register-right{
            width: 100%;
        }

        .register-right{
            padding: 50px 20px;
        }
    }

</style>



<div class="register-wrapper">

    <div class="register-box">

        
        <div class="register-left">

            <div class="register-title">
                📝 Crear Cuenta
            </div>

            <div class="register-subtitle">
                Registra un nuevo usuario en el sistema
            </div>

            
            @if ($errors->any())

                <div class="alert">

                    <ul>

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            
            <form method="POST" action="{{ route('register') }}">

                @csrf

                
                <div class="form-group">

                    <label class="form-label">
                        Nombre Completo
                    </label>

                    <input type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name') }}"
                        placeholder="Ingrese el nombre"
                        required>

                </div>

                
                <div class="form-group">

                    <label class="form-label">
                        Correo Electrónico
                    </label>

                    <input type="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email') }}"
                        placeholder="correo@ejemplo.com"
                        required>

                </div>

                
                <div class="form-group">

                    <label class="form-label">
                        Contraseña
                    </label>

                    <input type="password"
                        name="password"
                        class="form-control"
                        placeholder="Ingrese la contraseña"
                        required>

                </div>

                
                <div class="form-group">

                    <label class="form-label">
                        Confirmar Contraseña
                    </label>

                    <input type="password"
                        name="password_confirmation"
                        class="form-control"
                        placeholder="Repita la contraseña"
                        required>

                </div>

                
                <button type="submit" class="btn-register">

                    🚀 Registrarse

                </button>

                
                <a href="{{ route('login') }}" class="btn-login">

                    🔐 Ya tengo cuenta

                </a>

            </form>

        </div>



        
        <div class="register-right">

            <div class="overlay-text">

                <h2>Bienvenido</h2>

                <p>
                    Sistema de Inventario Escolar
                </p>

            </div>

            <img src="{{ asset('img/logoinicio1.jpg') }}" alt="Logo">

        </div>

    </div>

</div>