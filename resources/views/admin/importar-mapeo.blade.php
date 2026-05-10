<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapeo de columnas - ITM Bolsa de empleo</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f5f5f5; color: #333; }
        .header { background: #1a3c6e; color: white; padding: 16px 40px; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { font-size: 18px; font-weight: 500; }
        .header-right { display: flex; align-items: center; gap: 16px; }
        .header-right span { font-size: 13px; opacity: 0.85; }
        .btn-logout { background: none; border: 1px solid rgba(255,255,255,0.4); color: white; padding: 6px 16px; border-radius: 6px; font-size: 13px; cursor: pointer; }
        .btn-logout:hover { background: rgba(255,255,255,0.1); }
        .container { max-width: 800px; margin: 30px auto; padding: 0 20px; }
        .card { background: white; border-radius: 10px; padding: 30px; border: 1px solid #e8e8e8; }
        .card h3 { color: #1a3c6e; font-size: 18px; font-weight: 600; margin-bottom: 6px; }
        .card p.sub { color: #666; font-size: 13px; margin-bottom: 20px; line-height: 1.5; }
        .info-bar { background: #E6F1FB; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; }
        .info-bar span { font-size: 13px; color: #0C447C; font-weight: 500; }
        .mapeo-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .mapeo-table th { background: #1a3c6e; color: white; padding: 10px 14px; text-align: left; font-size: 13px; font-weight: 500; }
        .mapeo-table td { padding: 10px 14px; border-bottom: 1px solid #f0f0f0; font-size: 13px; }
        .mapeo-table tr:hover { background: #f9f9f9; }
        .mapeo-table .col-excel { color: #1a3c6e; font-weight: 500; }
        .mapeo-table .flecha { color: #999; text-align: center; }
        .mapeo-table select { width: 100%; padding: 8px 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 13px; font-family: 'Segoe UI', sans-serif; }
        .mapeo-table select:focus { outline: none; border-color: #2d6ab8; }
        .actions { display: flex; gap: 10px; }
        .btn-importar { background: #1a3c6e; color: white; padding: 12px 30px; border: none; border-radius: 6px; font-size: 14px; font-weight: 600; cursor: pointer; flex: 1; }
        .btn-importar:hover { background: #15325a; }
        .btn-cancelar { background: white; color: #666; padding: 12px 30px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; cursor: pointer; text-decoration: none; text-align: center; }
        .btn-cancelar:hover { background: #f5f5f5; }
        .alert-error { background: #fee2e2; border: 1px solid #fecaca; color: #991b1b; padding: 14px 18px; border-radius: 8px; margin-bottom: 20px; font-size: 13px; }
        .nota { background: #FAEEDA; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 12px; color: #854F0B; line-height: 1.6; }
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

        @if($errors->has('error'))
        <div class="alert-error">{{ $errors->first('error') }}</div>
        @endif

        <div class="card">
            <h3>Asignar columnas del archivo</h3>
            <p class="sub">Seleccione a qué campo del sistema corresponde cada columna de su archivo Excel. Las columnas que no necesite pueden dejarse como "No importar".</p>

            <div class="info-bar">
                <span>Columnas detectadas: {{ count($headers) }}</span>
                <span>Total de registros: {{ $totalFilas }}</span>
            </div>

            <div class="nota">
                <strong>Importante:</strong> El campo "Número de documento" es obligatorio para la importación. Los registros con documento o correo duplicado serán omitidos automáticamente.
            </div>

            <form method="POST" action="{{ route('admin.importar.ejecutar') }}" id="form-importar">
                @csrf
                <input type="hidden" name="ruta_temporal" value="{{ $rutaTemporal }}">

                <table class="mapeo-table">
                    <thead>
                        <tr>
                            <th style="width: 40%;">Columna del archivo</th>
                            <th style="width: 10%;">→</th>
                            <th style="width: 50%;">Campo del sistema</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($headers as $index => $header)
                        <tr>
                            <td class="col-excel">{{ $header }}</td>
                            <td class="flecha">→</td>
                            <td>
                                <select name="mapeo[{{ $index }}]">
                                    @foreach($camposBD as $campo => $label)
                                    <option value="{{ $campo }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="actions">
                    <a href="{{ route('admin.importar') }}" class="btn-cancelar">Cancelar</a>
                    <button type="button" class="btn-importar" onclick="validarYConfirmar()">Importar {{ $totalFilas }} registros</button>
                </div>
            </form>
        </div>

    </div>

    <footer class="footer">
        <p>Instituto Tecnológico Metropolitano &mdash; Programa de Egresados</p>
        <p>Campus Fraternidad &mdash; &copy; {{ date('Y') }}</p>
    </footer>

    <script>
    function mostrarModal(titulo, mensaje, colorTitulo, botones) {
        var overlay = document.createElement('div');
        overlay.style.cssText = 'position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);display:flex;align-items:center;justify-content:center;z-index:9999;';
        var modal = document.createElement('div');
        modal.style.cssText = 'background:white;border-radius:10px;padding:30px 40px;text-align:center;max-width:420px;box-shadow:0 4px 20px rgba(0,0,0,0.15);';
        var html = '<h3 style="color:' + colorTitulo + ';margin-bottom:10px;font-family:Segoe UI,sans-serif;">' + titulo + '</h3>';
        html += '<p style="color:#555;font-size:14px;margin-bottom:20px;font-family:Segoe UI,sans-serif;">' + mensaje + '</p>';
        html += '<div style="display:flex;gap:10px;justify-content:center;">' + botones + '</div>';
        modal.innerHTML = html;
        overlay.appendChild(modal);
        document.body.appendChild(overlay);
        overlay.addEventListener('click', function(e) { if (e.target === overlay) overlay.remove(); });
        return overlay;
    }

    function validarYConfirmar() {
        var selects = document.querySelectorAll('.mapeo-table select');
        var valores = [];
        var duplicado = false;

        selects.forEach(function(sel) {
            if (sel.value !== '') {
                if (valores.includes(sel.value)) {
                    duplicado = true;
                }
                valores.push(sel.value);
            }
        });

        if (duplicado) {
            mostrarModal(
                'Error de mapeo',
                'No puede asignar el mismo campo del sistema a dos columnas diferentes. Revise la asignación.',
                '#e53e3e',
                '<button onclick="this.closest(\'div\').parentElement.parentElement.remove()" style="background:#1a3c6e;color:white;border:none;padding:10px 30px;border-radius:6px;font-size:14px;cursor:pointer;font-family:Segoe UI,sans-serif;">Entendido</button>'
            );
            return;
        }

        if (!valores.includes('numero_documento')) {
            mostrarModal(
                'Campo obligatorio',
                'Debe asignar al menos el campo "Número de documento" para poder importar.',
                '#e53e3e',
                '<button onclick="this.closest(\'div\').parentElement.parentElement.remove()" style="background:#1a3c6e;color:white;border:none;padding:10px 30px;border-radius:6px;font-size:14px;cursor:pointer;font-family:Segoe UI,sans-serif;">Entendido</button>'
            );
            return;
        }

        mostrarModal(
            'Confirmar importación',
            '¿Está seguro de importar {{ $totalFilas }} registros? Esta acción no se puede deshacer.',
            '#1a3c6e',
            '<button onclick="this.closest(\'div\').parentElement.parentElement.remove()" style="background:white;color:#666;border:1px solid #ccc;padding:10px 24px;border-radius:6px;font-size:14px;cursor:pointer;font-family:Segoe UI,sans-serif;">Cancelar</button><button onclick="document.getElementById(\'form-importar\').submit()" style="background:#1a3c6e;color:white;border:none;padding:10px 24px;border-radius:6px;font-size:14px;cursor:pointer;font-family:Segoe UI,sans-serif;">Sí, importar</button>'
        );
    }
    </script>

    <script>
    var tiempoInactividad;
    function reiniciarTemporizador() {
        clearTimeout(tiempoInactividad);
        tiempoInactividad = setTimeout(function() {
            mostrarModal(
                'Sesión expirada',
                'Su sesión ha expirado por inactividad.',
                '#1a3c6e',
                '<button onclick="cerrarSesion()" style="background:#1a3c6e;color:white;border:none;padding:10px 30px;border-radius:6px;font-size:14px;cursor:pointer;font-family:Segoe UI,sans-serif;">Aceptar</button>'
            );
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