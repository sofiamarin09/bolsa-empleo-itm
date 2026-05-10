<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administradores - ITM Bolsa de empleo</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f5f5f5; color: #333; }

        .header { background: #1a3c6e; color: white; padding: 16px 40px; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { font-size: 18px; font-weight: 500; }
        .header-right { display: flex; align-items: center; gap: 16px; }
        .header-right span { font-size: 13px; opacity: 0.85; }
        .btn-logout { background: none; border: 1px solid rgba(255,255,255,0.4); color: white; padding: 6px 16px; border-radius: 6px; font-size: 13px; cursor: pointer; transition: background 0.2s; }
        .btn-logout:hover { background: rgba(255,255,255,0.1); }

        .container { max-width: 1100px; margin: 30px auto; padding: 0 20px; }

        .page-title { color: #1a3c6e; font-size: 22px; font-weight: 600; margin-bottom: 24px; }

        .nav-links { display: flex; gap: 12px; margin-bottom: 28px; }
        .nav-link { padding: 8px 18px; border-radius: 6px; font-size: 13px; text-decoration: none; border: 1px solid #e8e8e8; color: #1a3c6e; background: white; transition: background 0.2s; }
        .nav-link:hover { background: #E6F1FB; }
        .nav-link.active { background: #1a3c6e; color: white; border-color: #1a3c6e; }

        .content-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }

        .card { background: white; border-radius: 10px; padding: 28px; border: 1px solid #e8e8e8; }
        .card h3 { color: #1a3c6e; font-size: 16px; font-weight: 600; margin-bottom: 20px; }

        .form-group { margin-bottom: 16px; }
        .form-group label { font-size: 13px; font-weight: 600; color: #444; display: block; margin-bottom: 6px; }
        .form-group label .required { color: #e53e3e; }
        .form-group input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            font-family: 'Segoe UI', sans-serif;
        }
        .form-group input:focus { outline: none; border-color: #2d6ab8; box-shadow: 0 0 0 3px rgba(45,106,184,0.12); }
        .form-group .hint { font-size: 11px; color: #999; margin-top: 4px; }

        .btn-crear {
            background: #1a3c6e;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: background 0.2s;
        }
        .btn-crear:hover { background: #15325a; }

        .admin-list { list-style: none; }
        .admin-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .admin-item:last-child { border-bottom: none; }
        .admin-info h4 { font-size: 14px; color: #1a3c6e; font-weight: 600; margin-bottom: 2px; }
        .admin-info p { font-size: 12px; color: #666; }
        .admin-info .fecha { font-size: 11px; color: #999; margin-top: 2px; }

        .badge-yo { display: inline-block; background: #d1fae5; color: #065f46; padding: 2px 8px; border-radius: 10px; font-size: 11px; font-weight: 500; margin-left: 6px; }

        .btn-eliminar {
            background: none;
            border: 1px solid #e53e3e;
            color: #e53e3e;
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 12px;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-eliminar:hover { background: #fee2e2; }

        .alert-success {
            background: #d1fae5;
            border: 1px solid #a7f3d0;
            color: #065f46;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 13px;
        }
        .alert-error {
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .error-msg { color: #e53e3e; font-size: 12px; margin-top: 4px; }

        .empty-state { text-align: center; color: #999; font-size: 14px; padding: 30px 0; }

        .footer { background: #1a3c6e; color: white; text-align: center; padding: 20px; margin-top: 40px; }
        .footer p { font-size: 12px; opacity: 0.7; margin-bottom: 2px; }

        @media (max-width: 768px) {
            .content-grid { grid-template-columns: 1fr; }
            .header { padding: 14px 20px; flex-direction: column; gap: 10px; }
        }
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
            <a href="{{ route('admin.administradores') }}" class="nav-link active">Administradores</a>
            <a href="{{ route('admin.graficas') }}" class="nav-link">Gráficas</a>
            <a href="{{ route('admin.importar') }}" class="nav-link">Importar Excel</a>
        </div>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->has('error'))
            <div class="alert-error">{{ $errors->first('error') }}</div>
        @endif

        <div class="content-grid">

            <div class="card">
                <h3>Crear nuevo administrador</h3>
                <form method="POST" action="{{ route('admin.administradores.crear') }}" autocomplete="off">
                    @csrf
                    <input type="text" name="fake_user" style="display:none;" aria-hidden="true">
                    <input type="password" name="fake_pass" style="display:none;" aria-hidden="true">
                    <div class="form-group">
                        <label>Nombre completo <span class="required">*</span></label>
                        <input type="text" name="nombre" value="{{ old('nombre') }}" autocomplete="one-time-code" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ0-9\s\-]+" minlength="2" oninvalid="this.setCustomValidity('El nombre debe tener mínimo 2 caracteres y solo contener letras y números')" oninput="this.setCustomValidity(''); this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑüÜ0-9\s\-]/g, '')" required>
                        @error('nombre') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Correo institucional <span class="required">*</span></label>
                        <input type="email" name="correo" value="{{ old('correo') }}" autocomplete="one-time-code" placeholder="ejemplo@itm.edu.co" pattern="[a-zA-Z0-9._%+\-]+@itm\.edu\.co" oninvalid="this.setCustomValidity('Solo se permiten correos institucionales @itm.edu.co')" oninput="this.setCustomValidity('')" required>
                        <p class="hint">Solo se permiten correos con dominio @itm.edu.co</p>
                        @error('correo') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Contraseña <span class="required">*</span></label>
                        <input type="password" name="password" autocomplete="one-time-code" minlength="8" oninvalid="this.setCustomValidity('La contraseña debe tener mínimo 8 caracteres')" oninput="this.setCustomValidity('')" required>
                        @error('password') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Confirmar contraseña <span class="required">*</span></label>
                        <input type="password" name="password_confirmation" autocomplete="one-time-code" minlength="8" oninvalid="this.setCustomValidity('Confirme la contraseña')" oninput="this.setCustomValidity('')" onpaste="return false" required>
                        @error('password_confirmation') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="btn-crear">Crear administrador</button>
                </form>
            </div>

            <div class="card">
                <h3>Administradores registrados ({{ $administradores->count() }})</h3>
                <ul class="admin-list">
                    @forelse($administradores as $admin)
                    <li class="admin-item">
                        <div class="admin-info">
                            <h4>
                                {{ $admin->nombre }}
                                @if($admin->id === $adminActualId)
                                    <span class="badge-yo">Tú</span>
                                @endif
                            </h4>
                            <p>{{ $admin->correo }}</p>
                            <p class="fecha">Creado: {{ $admin->created_at ? $admin->created_at->format('d/m/Y H:i') : 'N/A' }}</p>
                        </div>
                        @if($admin->id !== $adminActualId && $admin->id !== 1)
                        <form method="POST" action="{{ route('admin.administradores.eliminar', $admin->id) }}" onsubmit="return confirm('¿Está seguro de eliminar a {{ $admin->nombre }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-eliminar">Eliminar</button>
                        </form>
                        @endif
                    </li>
                    @empty
                    <li class="empty-state">No hay administradores registrados.</li>
                    @endforelse
                </ul>
            </div>

        </div>

    </div>

    <footer class="footer">
        <p>Instituto Tecnológico Metropolitano &mdash; Programa de Egresados</p>
        <p>Campus Fraternidad &mdash; &copy; {{ date('Y') }}</p>
    </footer>

    <script>
    document.querySelectorAll('input:not([type="checkbox"]):not([type="date"]):not([style*="display:none"])').forEach(function(input) {
        input.setAttribute('readonly', true);
        input.addEventListener('focus', function() {
            this.removeAttribute('readonly');
        });
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