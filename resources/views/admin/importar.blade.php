<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importar Excel - ITM Bolsa de empleo</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f5f5f5; color: #333; }
        .header { background: #1a3c6e; color: white; padding: 16px 40px; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { font-size: 18px; font-weight: 500; }
        .header-right { display: flex; align-items: center; gap: 16px; }
        .header-right span { font-size: 13px; opacity: 0.85; }
        .btn-logout { background: none; border: 1px solid rgba(255,255,255,0.4); color: white; padding: 6px 16px; border-radius: 6px; font-size: 13px; cursor: pointer; }
        .btn-logout:hover { background: rgba(255,255,255,0.1); }
        .container { max-width: 1100px; margin: 30px auto; padding: 0 20px; }
        .nav-links { display: flex; gap: 12px; margin-bottom: 28px; }
        .nav-link { padding: 8px 18px; border-radius: 6px; font-size: 13px; text-decoration: none; border: 1px solid #e8e8e8; color: #1a3c6e; background: white; }
        .nav-link:hover { background: #E6F1FB; }
        .nav-link.active { background: #1a3c6e; color: white; border-color: #1a3c6e; }
        .card { background: white; border-radius: 10px; padding: 30px; border: 1px solid #e8e8e8; max-width: 600px; }
        .card h3 { color: #1a3c6e; font-size: 18px; font-weight: 600; margin-bottom: 8px; }
        .card p { color: #666; font-size: 13px; line-height: 1.6; margin-bottom: 20px; }
        .upload-area { border: 2px dashed #ccc; border-radius: 10px; padding: 40px; text-align: center; margin-bottom: 20px; cursor: pointer; transition: border-color 0.2s; }
        .upload-area:hover { border-color: #1a3c6e; }
        .upload-area p { color: #999; font-size: 14px; margin-bottom: 8px; }
        .upload-area .hint { font-size: 12px; color: #bbb; }
        .upload-area input[type="file"] { display: none; }
        .upload-area .filename { color: #1a3c6e; font-weight: 600; font-size: 14px; }
        .btn-subir { background: #1a3c6e; color: white; padding: 12px 30px; border: none; border-radius: 6px; font-size: 14px; font-weight: 600; cursor: pointer; width: 100%; }
        .btn-subir:hover { background: #15325a; }
        .btn-subir:disabled { background: #ccc; cursor: not-allowed; }
        .alert-success { background: #d1fae5; border: 1px solid #a7f3d0; color: #065f46; padding: 16px; border-radius: 8px; margin-bottom: 20px; font-size: 13px; line-height: 1.6; }
        .alert-error { background: #fee2e2; border: 1px solid #fecaca; color: #991b1b; padding: 14px 18px; border-radius: 8px; margin-bottom: 20px; font-size: 13px; }
        .resultado-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; margin-top: 12px; }
        .resultado-item { text-align: center; padding: 12px; border-radius: 8px; }
        .resultado-item.nuevos { background: #d1fae5; }
        .resultado-item.duplicados { background: #FAEEDA; }
        .resultado-item.errores { background: #fee2e2; }
        .resultado-item .num { font-size: 24px; font-weight: 600; }
        .resultado-item.nuevos .num { color: #065f46; }
        .resultado-item.duplicados .num { color: #854F0B; }
        .resultado-item.errores .num { color: #991b1b; }
        .resultado-item .lbl { font-size: 12px; color: #666; margin-top: 4px; }
        .error-msg { color: #e53e3e; font-size: 12px; margin-top: 8px; }
        .footer { background: #1a3c6e; color: white; text-align: center; padding: 20px; margin-top: 40px; }
        .footer p { font-size: 12px; opacity: 0.7; margin-bottom: 2px; }
    </style>
</head>
<body>

    <header class="header">
        <h1>ITM - Panel de administración</h1>
        <div class="header-right">
            <span>{{ Session::get('admin_nombre') }}</span>
            <form method="POST" action="{{ route('admin.logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="btn-logout">Cerrar sesión</button>
            </form>
        </div>
    </header>

    <div class="container">

        <div class="nav-links">
            <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a>
            <a href="{{ route('admin.usuarios') }}" class="nav-link">Usuarios</a>
            @if(Session::get('admin_rol') === 'superadmin')
            <a href="{{ route('admin.administradores') }}" class="nav-link">Administrador</a>
            @endif
            <a href="{{ route('admin.graficas') }}" class="nav-link">Gráficas</a>
            <a href="{{ route('admin.importar') }}" class="nav-link active">Importar Excel</a>
        </div>

        @if(session('resultado'))
        <div class="alert-success">
            <strong>Importación completada exitosamente.</strong>
            <div class="resultado-grid">
                <div class="resultado-item nuevos">
                    <p class="num">{{ session('resultado')['nuevos'] }}</p>
                    <p class="lbl">Nuevos registros</p>
                </div>
                <div class="resultado-item duplicados">
                    <p class="num">{{ session('resultado')['duplicados'] }}</p>
                    <p class="lbl">Duplicados omitidos</p>
                </div>
                <div class="resultado-item errores">
                    <p class="num">{{ session('resultado')['errores'] }}</p>
                    <p class="lbl">Errores</p>
                </div>
            </div>
        </div>
        @endif

        @if($errors->has('error'))
        <div class="alert-error">{{ $errors->first('error') }}</div>
        @endif

        <div class="card">
            <h3>Importar aspirantes desde Excel</h3>
            <p>Suba un archivo Excel (.xlsx, .xls) o CSV con la información de los aspirantes. En el siguiente paso podrá asignar las columnas del archivo a los campos del sistema.</p>

            <form method="POST" action="{{ route('admin.importar.subir') }}" enctype="multipart/form-data">
                @csrf
                <div class="upload-area" onclick="document.getElementById('archivo').click()">
                    <p id="upload-text">Haga clic para seleccionar un archivo</p>
                    <p class="hint">Formatos aceptados: .xlsx, .xls, .csv — Máximo 20MB</p>
                    <input type="file" name="archivo" id="archivo" accept=".xlsx,.xls,.csv">
                </div>
                @error('archivo') <p class="error-msg">{{ $message }}</p> @enderror
                <button type="submit" class="btn-subir" id="btn-subir" disabled>Subir y continuar</button>
            </form>
        </div>

    </div>

    <footer class="footer">
        <p>Instituto Tecnológico Metropolitano &mdash; Programa de Egresados</p>
        <p>Campus Fraternidad</p>
    </footer>

    <script>
    document.getElementById('archivo').addEventListener('change', function() {
        var nombre = this.files[0] ? this.files[0].name : '';
        if (nombre) {
            document.getElementById('upload-text').innerHTML = '<span class="filename">' + nombre + '</span>';
            document.getElementById('btn-subir').disabled = false;
        }
    });
    </script>

    <script>
    var tiempoInactividad;
    function reiniciarTemporizador() {
        clearTimeout(tiempoInactividad);
        tiempoInactividad = setTimeout(function() {
            var overlay = document.createElement('div');
            overlay.style.cssText = 'position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);display:flex;align-items:center;justify-content:center;z-index:9999;';
            var modal = document.createElement('div');
            modal.style.cssText = 'background:white;border-radius:10px;padding:30px 40px;text-align:center;max-width:400px;box-shadow:0 4px 20px rgba(0,0,0,0.15);';
            modal.innerHTML = '<h3 style="color:#1a3c6e;margin-bottom:10px;font-family:Segoe UI,sans-serif;">Sesión expirada</h3><p style="color:#555;font-size:14px;margin-bottom:20px;font-family:Segoe UI,sans-serif;">Su sesión ha expirado por inactividad.</p><button onclick="cerrarSesion()" style="background:#1a3c6e;color:white;border:none;padding:10px 30px;border-radius:6px;font-size:14px;cursor:pointer;font-family:Segoe UI,sans-serif;">Aceptar</button>';
            overlay.appendChild(modal);
            document.body.appendChild(overlay);
        }, 3600000);
    }
    function cerrarSesion() {
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.logout") }}';
        var csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        form.appendChild(csrf);
        document.body.appendChild(form);
        form.submit();
    }
    document.addEventListener('mousemove', reiniciarTemporizador);
    document.addEventListener('keypress', reiniciarTemporizador);
    document.addEventListener('click', reiniciarTemporizador);
    document.addEventListener('scroll', reiniciarTemporizador);
    reiniciarTemporizador();
    </script>

</body>
</html>