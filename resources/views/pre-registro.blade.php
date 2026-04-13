<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pre-registro - ITM Bolsa de empleo</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f5f5f5; color: #333; }

        .header { background: #1a3c6e; color: white; padding: 18px 40px; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { font-size: 20px; font-weight: 500; }
        .header nav a { color: white; text-decoration: none; margin-left: 24px; font-size: 14px; opacity: 0.85; }
        .header nav a:hover { opacity: 1; text-decoration: underline; }

        .container { max-width: 800px; margin: 40px auto; padding: 0 20px; }
        .form-card { background: white; border-radius: 10px; padding: 40px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid #e8e8e8; }
        .form-card h2 { color: #1a3c6e; margin-bottom: 6px; font-size: 24px; font-weight: 600; }
        .form-card p.subtitle { color: #666; margin-bottom: 28px; font-size: 14px; line-height: 1.5; }

        .form-section { margin-bottom: 24px; padding-bottom: 20px; border-bottom: 1px solid #eee; }
        .form-section:last-of-type { border-bottom: none; }
        .form-section h3 { color: #1a3c6e; font-size: 16px; font-weight: 600; margin-bottom: 16px; }

        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 14px; }
        .form-group { display: flex; flex-direction: column; }
        .form-group.full { grid-column: 1 / -1; }

        label { font-size: 13px; font-weight: 600; margin-bottom: 4px; color: #444; }
        label .required { color: #e53e3e; }

        input, select {
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            font-family: 'Segoe UI', sans-serif;
            transition: border 0.2s, box-shadow 0.2s;
            background: white;
        }
        input:focus, select:focus {
            outline: none;
            border-color: #2d6ab8;
            box-shadow: 0 0 0 3px rgba(45,106,184,0.12);
        }
        input.error, select.error {
            border-color: #e53e3e;
        }

        .checkbox-group { display: flex; align-items: flex-start; gap: 10px; margin-top: 8px; }
        .checkbox-group input[type="checkbox"] { margin-top: 3px; width: 16px; height: 16px; cursor: pointer; }
        .checkbox-group label { font-weight: 400; font-size: 13px; line-height: 1.6; cursor: pointer; }

        .btn-submit {
            background: #1a3c6e;
            color: white;
            padding: 14px 36px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            margin-top: 24px;
            transition: background 0.2s;
        }
        .btn-submit:hover { background: #15325a; }

        .error-msg { color: #e53e3e; font-size: 12px; margin-top: 4px; }

        .alert-error {
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 14px 18px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-size: 14px;
            line-height: 1.5;
        }

        .footer { background: #1a3c6e; color: white; text-align: center; padding: 24px 20px; margin-top: 60px; }
        .footer p { font-size: 13px; opacity: 0.8; margin-bottom: 4px; }
        .footer p:last-child { opacity: 0.6; font-size: 12px; margin-bottom: 0; }

        @media (max-width: 600px) {
            .header { padding: 14px 20px; flex-direction: column; gap: 10px; }
            .form-row { grid-template-columns: 1fr; }
            .form-card { padding: 24px 18px; }
        }
    </style>
</head>
<body>

    <header class="header">
        <h1>ITM - Bolsa de empleo</h1>
        <nav>
            <a href="/">Inicio</a>
            <a href="/pre-registro">Pre-registro</a>
        </nav>
    </header>

    <div class="container">
        <div class="form-card">
            <h2>Formulario de pre-registro</h2>
            <p class="subtitle">Complete todos los campos obligatorios (*) para registrarse en la Bolsa de Empleo del ITM.</p>

            @if($errors->has('error'))
                <div class="alert-error">{{ $errors->first('error') }}</div>
            @endif

            <form method="POST" action="{{ route('pre-registro.store') }}">
                @csrf

                <div class="form-section">
                    <h3>Identificación</h3>
                    <div class="form-row">
                        <div class="form-group full">
                            <label>Tipo de documento <span class="required">*</span></label>
                            <select name="tipo_documento" required>
                                <option value="">Seleccione...</option>
                                <option value="cedula_ciudadania" {{ old('tipo_documento') == 'cedula_ciudadania' ? 'selected' : '' }}>Cédula de ciudadanía</option>
                                <option value="tarjeta_identidad" {{ old('tipo_documento') == 'tarjeta_identidad' ? 'selected' : '' }}>Tarjeta de identidad</option>
                                <option value="documento_nacional" {{ old('tipo_documento') == 'documento_nacional' ? 'selected' : '' }}>Documento nacional de identificación</option>
                            </select>
                            @error('tipo_documento') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Número de documento <span class="required">*</span></label>
                            <input type="text" name="numero_documento" value="{{ old('numero_documento') }}" required>
                            @error('numero_documento') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Confirmar número de documento <span class="required">*</span></label>
                            <input type="text" name="confirmar_documento" value="{{ old('confirmar_documento') }}" required>
                            @error('confirmar_documento') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3>Información de contacto</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Correo electrónico <span class="required">*</span></label>
                            <input type="email" name="correo" value="{{ old('correo') }}" required>
                            @error('correo') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Confirmar correo electrónico <span class="required">*</span></label>
                            <input type="email" name="confirmar_correo" value="{{ old('confirmar_correo') }}" required>
                            @error('confirmar_correo') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Teléfono celular <span class="required">*</span></label>
                            <input type="text" name="telefono_celular" value="{{ old('telefono_celular') }}" required>
                            @error('telefono_celular') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3>Datos personales</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Primer nombre <span class="required">*</span></label>
                            <input type="text" name="primer_nombre" value="{{ old('primer_nombre') }}" required>
                            @error('primer_nombre') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Segundo nombre</label>
                            <input type="text" name="segundo_nombre" value="{{ old('segundo_nombre') }}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Primer apellido <span class="required">*</span></label>
                            <input type="text" name="primer_apellido" value="{{ old('primer_apellido') }}" required>
                            @error('primer_apellido') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Segundo apellido</label>
                            <input type="text" name="segundo_apellido" value="{{ old('segundo_apellido') }}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Fecha de nacimiento <span class="required">*</span></label>
                            <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required>
                            @error('fecha_nacimiento') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Sexo <span class="required">*</span></label>
                            <select name="sexo" required>
                                <option value="">Seleccione...</option>
                                <option value="masculino" {{ old('sexo') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="femenino" {{ old('sexo') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                            </select>
                            @error('sexo') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3>Ubicación</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label>País de residencia <span class="required">*</span></label>
                            <input type="text" name="pais" value="{{ old('pais', 'Colombia') }}" required>
                            @error('pais') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Departamento <span class="required">*</span></label>
                            <input type="text" name="departamento" value="{{ old('departamento') }}" required>
                            @error('departamento') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Municipio <span class="required">*</span></label>
                            <input type="text" name="municipio" value="{{ old('municipio') }}" required>
                            @error('municipio') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3>Pregunta de seguridad</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Pregunta de seguridad <span class="required">*</span></label>
                            <select name="pregunta_seguridad_id" required>
                                <option value="">Seleccione...</option>
                                @foreach($preguntas as $pregunta)
                                    <option value="{{ $pregunta->id }}" {{ old('pregunta_seguridad_id') == $pregunta->id ? 'selected' : '' }}>{{ $pregunta->pregunta }}</option>
                                @endforeach
                            </select>
                            @error('pregunta_seguridad_id') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Respuesta de seguridad <span class="required">*</span></label>
                            <input type="text" name="respuesta_seguridad" value="{{ old('respuesta_seguridad') }}" required>
                            @error('respuesta_seguridad') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3>Tratamiento de datos personales</h3>
                    <div class="checkbox-group">
                        <input type="checkbox" name="acepta_terminos" id="acepta_terminos" value="1" {{ old('acepta_terminos') ? 'checked' : '' }}>
                        <label for="acepta_terminos">
                            Autorizo al Instituto Tecnológico Metropolitano (ITM) para el tratamiento de mis datos personales,
                            de conformidad con la Ley 1581 de 2012 y su Decreto Reglamentario 1377 de 2013, para los fines
                            relacionados con el proceso de pre-registro a la Bolsa de Empleo. <span class="required">*</span>
                        </label>
                    </div>
                    @error('acepta_terminos') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="btn-submit">Enviar pre-registro</button>
            </form>
        </div>
    </div>

    <footer class="footer">
        <p>Instituto Tecnológico Metropolitano &mdash; Oficina de Egresados</p>
        <p>Campus Fraternidad &mdash; &copy; {{ date('Y') }}</p>
    </footer>

</body>
</html>