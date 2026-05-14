<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Recuperar contraseña - ITM</title>
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Segoe UI', sans-serif; background: #f5f5f5; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
    .card { background: white; border-radius: 12px; padding: 40px; width: 100%; max-width: 420px; border: 1px solid #e8e8e8; box-shadow: 0 2px 12px rgba(0,0,0,0.07); }
    .logo { text-align: center; margin-bottom: 28px; }
    .logo h2 { color: #1a3c6e; font-size: 20px; font-weight: 600; }
    .logo p { color: #888; font-size: 13px; margin-top: 4px; }
    .form-group { margin-bottom: 18px; }
    .form-group label { font-size: 13px; color: #444; display: block; margin-bottom: 6px; font-weight: 500; }
    .form-group input { width: 100%; padding: 10px 14px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; font-family: 'Segoe UI', sans-serif; }
    .form-group input:focus { outline: none; border-color: #2d6ab8; }
    .btn { width: 100%; background: #1a3c6e; color: white; padding: 11px; border: none; border-radius: 6px; font-size: 14px; font-weight: 600; cursor: pointer; margin-top: 6px; }
    .btn:hover { background: #15325a; }
    .alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; border-radius: 6px; padding: 10px 14px; font-size: 13px; margin-bottom: 16px; }
    .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; border-radius: 6px; padding: 10px 14px; font-size: 13px; margin-bottom: 16px; }
    .back-link { display: block; text-align: center; margin-top: 18px; font-size: 13px; color: #1a3c6e; text-decoration: none; }
    .back-link:hover { text-decoration: underline; }
    .description { font-size: 13px; color: #666; margin-bottom: 20px; line-height: 1.5; }
</style>
</head>
<body>

<div class="card">
    <div class="logo">
        <h2>ITM - Panel de administración</h2>
        <p>Recuperación de contraseña</p>
    </div>

    @if($errors->any())
        <div class="alert-error">{{ $errors->first() }}</div>
    @endif

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <p class="description">Ingrese su correo institucional y le enviaremos un enlace para restablecer su contraseña. El enlace expira en 60 minutos.</p>

    <form method="POST" action="{{ route('admin.forgot-password.send') }}">
        @csrf
        <div class="form-group">
            <label>Correo electrónico</label>
            <input type="email" name="correo" value="{{ old('correo') }}" placeholder="usuario@itm.edu.co" required>
        </div>
        <button type="submit" class="btn">Enviar enlace de recuperación</button>
    </form>

    <a href="{{ route('admin.login') }}" class="back-link">Volver al inicio de sesión</a>
</div>

</body>
</html>
