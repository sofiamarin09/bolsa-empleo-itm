<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>Administración - ITM Bolsa de empleo</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Montserrat', sans-serif; background: #f5f5f5; color: #333; display: flex; flex-direction: column; min-height: 100vh; }

        .login-wrapper { flex: 1; display: flex; align-items: center; justify-content: center; padding: 40px 20px; }

        .login-card {
            background: white;
            border-radius: 10px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            border: 1px solid #e8e8e8;
        }

        .login-header { text-align: center; margin-bottom: 32px; }
        .login-header h1 { color: #1a3c6e; font-size: 22px; font-weight: 600; margin-bottom: 6px; }
        .login-header p { color: #666; font-size: 14px; }

        .form-group { margin-bottom: 18px; }
        label { font-size: 13px; font-weight: 600; color: #444; display: block; margin-bottom: 6px; }

        input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            font-family: 'Montserrat', sans-serif;
            transition: border 0.2s;
        }
        input:focus {
            outline: none;
            border-color: #2d6ab8;
            box-shadow: 0 0 0 3px rgba(45,106,184,0.12);
        }

        .btn-login {
            background: #1a3c6e;
            color: white;
            padding: 14px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            margin-top: 8px;
            transition: background 0.2s;
        }
        .btn-login:hover { background: #15325a; }

        .alert-error {
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #1a3c6e;
            font-size: 13px;
            text-decoration: none;
        }
        .back-link:hover { text-decoration: underline; }

        .login-page-header { background: #1a3c6e; padding: 16px 40px; }

        .footer-logos-section { background: white; text-align: center; padding: 28px 20px; border-top: 1px solid #e8e8e8; }
        .footer-logos-inner { display: flex; align-items: center; justify-content: center; gap: 36px; margin-bottom: 12px; flex-wrap: wrap; }
        .footer-logos-divider { width: 1px; height: 64px; background: #ccc; }
        .footer-legal { font-size: 12px; color: #666; max-width: 580px; margin: 0 auto; line-height: 1.6; }
    </style>
</head>
<body>

    <header class="login-page-header">
        <a href="/"><img src="/images/logo-itm.svg" alt="ITM" style="height: 40px; filter: brightness(0) invert(1);"></a>
    </header>

    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-header">
                <h1>ITM - Bolsa de empleo</h1>
                <p>Panel de administración</p>
            </div>

            @if($errors->has('error'))
                <div class="alert-error">{{ $errors->first('error') }}</div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}" autocomplete="off">
                @csrf

                <div class="form-group">
                    <label>Correo electrónico</label>
                    <input type="email" name="correo" value="{{ old('correo') }}" oninvalid="this.setCustomValidity('Ingrese su correo electrónico')" oninput="this.setCustomValidity('')" required>
                </div>

                <div class="form-group">
                    <label>Contraseña</label>
                    <input type="password" name="password" oninvalid="this.setCustomValidity('Ingrese su contraseña')" oninput="this.setCustomValidity('')" required>
                </div>

                <button type="submit" class="btn-login">Iniciar sesión</button>
            </form>

            <a href="{{ route('admin.forgot-password') }}" style="display:block; text-align:center; margin-top:14px; font-size:13px; color:#1a3c6e; text-decoration:none;">¿Olvidaste tu contraseña?</a>

            <a href="/" class="back-link">Volver al inicio</a>
        </div>
    </div>

    <div class="footer-logos-section">
        <div class="footer-logos-inner">
            <img src="/images/logo-spe.png" alt="Servicio Público de Empleo" style="height: 70px; object-fit: contain;">
            <div class="footer-logos-divider"></div>
            <img src="/images/logo-itm.svg" alt="Instituto Tecnológico Metropolitano" style="height: 50px; object-fit: contain; filter: brightness(0);">
        </div>
        <p class="footer-legal">Prestador autorizado según resolución número 0304 del 07 de julio 2022 de la Unidad Administrativa Especial del Servicio Público de Empleo</p>
    </div>

</body>
</html>
