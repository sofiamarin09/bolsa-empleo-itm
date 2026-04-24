<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración - ITM Bolsa de empleo</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f5f5f5; color: #333; display: flex; min-height: 100vh; align-items: center; justify-content: center; }

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
            font-family: 'Segoe UI', sans-serif;
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
    </style>
</head>
<body>

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

        <a href="/" class="back-link">Volver al inicio</a>
    </div>

</body>
</html>