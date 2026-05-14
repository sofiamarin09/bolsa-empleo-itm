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
 
            <form method="POST" action="{{ route('pre-registro.store') }}" autocomplete="off">
                @csrf
 
                <div class="form-section">
<h3>Identificación</h3>
<div class="form-row">
<div class="form-group full">
<label>Tipo de documento <span class="required">*</span></label>
<select name="tipo_documento" oninvalid="this.setCustomValidity('Seleccione un tipo de documento')" oninput="this.setCustomValidity('')" required>
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
<input type="text" name="numero_documento" value="{{ old('numero_documento') }}" autocomplete="off" pattern="[0-9]+" minlength="6" maxlength="15" oninvalid="this.setCustomValidity('El número de documento debe tener entre 6 y 15 dígitos numéricos')" oninput="this.setCustomValidity(''); this.value = this.value.replace(/[^0-9]/g, '')" required>
                            @error('numero_documento') <span class="error-msg">{{ $message }}</span> @enderror
</div>
<div class="form-group">
<label>Confirmar número de documento <span class="required">*</span></label>
<input type="text" name="confirmar_documento" value="{{ old('confirmar_documento') }}" autocomplete="off" pattern="[0-9]+" minlength="6" maxlength="15" oninvalid="this.setCustomValidity('El número de documento debe tener entre 6 y 15 dígitos numéricos')" oninput="this.setCustomValidity(''); this.value = this.value.replace(/[^0-9]/g, '')" onpaste="return false" required>
                            @error('confirmar_documento') <span class="error-msg">{{ $message }}</span> @enderror
</div>
</div>
</div>
 
                <div class="form-section">
<h3>Información de contacto</h3>
<div class="form-row">
<div class="form-group">
<label>Correo electrónico <span class="required">*</span></label>
<input type="email" name="correo" value="{{ old('correo') }}" autocomplete="off" pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}" oninvalid="this.setCustomValidity('Ingrese un correo válido (ejemplo: usuario@correo.com)')" oninput="this.setCustomValidity('')" required>
                            @error('correo') <span class="error-msg">{{ $message }}</span> @enderror
</div>
<div class="form-group">
<label>Confirmar correo electrónico <span class="required">*</span></label>
<input type="email" name="confirmar_correo" value="{{ old('confirmar_correo') }}" autocomplete="off" pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}" oninvalid="this.setCustomValidity('Ingrese un correo válido (ejemplo: usuario@correo.com)')" oninput="this.setCustomValidity('')" onpaste="return false" required>
                            @error('confirmar_correo') <span class="error-msg">{{ $message }}</span> @enderror
</div>
</div>
<div class="form-row">
<div class="form-group">
<label>Teléfono <span class="required">*</span></label>
                            <input type="text" name="telefono" value="{{ old('telefono') }}" autocomplete="off" pattern="[+0-9]+" minlength="7" maxlength="15" oninvalid="this.setCustomValidity('El teléfono debe tener entre 7 y 15 dígitos, solo números y el carácter +')" oninput="this.setCustomValidity(''); this.value = this.value.replace(/[^+0-9]/g, '')" required>
                            @error('telefono') <span class="error-msg">{{ $message }}</span> @enderror
</div>
</div>
</div>
 
                <div class="form-section">
<h3>Datos personales</h3>
<div class="form-row">
<div class="form-group">
<label>Primer nombre <span class="required">*</span></label>
<input type="text" name="primer_nombre" value="{{ old('primer_nombre') }}" autocomplete="off" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s\-]+" minlength="2" oninvalid="this.setCustomValidity('El nombre debe tener mínimo 2 caracteres y solo contener letras')" oninput="this.setCustomValidity(''); this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s\-]/g, '')" required>
                            @error('primer_nombre') <span class="error-msg">{{ $message }}</span> @enderror
</div>
<div class="form-group">
<label>Segundo nombre</label>
<input type="text" name="segundo_nombre" value="{{ old('segundo_nombre') }}" autocomplete="off" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s\-]{2,}" oninvalid="this.setCustomValidity('El nombre debe tener mínimo 2 caracteres y solo contener letras')" oninput="this.setCustomValidity(''); this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s\-]/g, ''); if(this.value.length === 1) this.setCustomValidity('El nombre debe tener mínimo 2 caracteres');">
</div>
</div>
<div class="form-row">
<div class="form-group">
<label>Primer apellido <span class="required">*</span></label>
<input type="text" name="primer_apellido" value="{{ old('primer_apellido') }}" autocomplete="off" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s\-]+" minlength="2" oninvalid="this.setCustomValidity('El apellido debe tener mínimo 2 caracteres y solo contener letras')" oninput="this.setCustomValidity(''); this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s\-]/g, '')" required>
                            @error('primer_apellido') <span class="error-msg">{{ $message }}</span> @enderror
</div>
<div class="form-group">
<label>Segundo apellido</label>
<input type="text" name="segundo_apellido" value="{{ old('segundo_apellido') }}" autocomplete="off" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s\-]{2,}" oninvalid="this.setCustomValidity('El apellido debe tener mínimo 2 caracteres y solo contener letras')" oninput="this.setCustomValidity(''); this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s\-]/g, ''); if(this.value.length === 1) this.setCustomValidity('El apellido debe tener mínimo 2 caracteres');">
</div>
</div>
<div class="form-row">
<div class="form-group">
<label>Fecha de nacimiento <span class="required">*</span></label>
<input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" max="{{ date('Y-m-d', strtotime('-14 years')) }}" min="{{ date('Y-m-d', strtotime('-100 years')) }}" oninvalid="this.setCustomValidity('Debe tener entre 14 y 100 años para registrarse')" oninput="this.setCustomValidity('')" required>
                            @error('fecha_nacimiento') <span class="error-msg">{{ $message }}</span> @enderror
</div>
<div class="form-group">
<label>Sexo <span class="required">*</span></label>
<select name="sexo" oninvalid="this.setCustomValidity('Seleccione su sexo')" oninput="this.setCustomValidity('')" required>
<option value="">Seleccione...</option>
<option value="masculino" {{ old('sexo') == 'masculino' ? 'selected' : '' }}>Masculino</option>
<option value="femenino" {{ old('sexo') == 'femenino' ? 'selected' : '' }}>Femenino</option>
<option value="intersexual" {{ old('sexo') == 'intersexual' ? 'selected' : '' }}>Intersexual</option>
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
<select id="pais" name="pais"
                                oninvalid="this.setCustomValidity('Seleccione un país')"
                                oninput="this.setCustomValidity('')"
                                onchange="cambiarPais(this.value)" required>
<option value="">Seleccione un país</option>
</select>
                            @error('pais') <span class="error-msg">{{ $message }}</span> @enderror
</div>
</div>
<div class="form-row" id="fila-departamento-municipio" style="display: none;">
<div class="form-group" id="grupo-departamento">
<label>Departamento <span class="required">*</span></label>
<select id="departamento" name="departamento"
                                onchange="cambiarDepartamento(this.value)"
                                oninvalid="this.setCustomValidity('Seleccione un departamento')"
                                oninput="this.setCustomValidity('')">
<option value="">Seleccione un departamento</option>
</select>
                            @error('departamento') <span class="error-msg">{{ $message }}</span> @enderror
</div>
<div class="form-group" id="grupo-municipio">
<label>Municipio <span class="required">*</span></label>
<select id="municipio" name="municipio"
                                oninvalid="this.setCustomValidity('Seleccione un municipio')"
                                oninput="this.setCustomValidity('')">
<option value="">Seleccione un municipio</option>
</select>
                            @error('municipio') <span class="error-msg">{{ $message }}</span> @enderror
</div>
</div>
</div>
 
<div class="form-section">
                    <h3>Términos, condiciones y tratamiento de datos personales</h3>

                    <div style="border: 1px solid #ccc; border-radius: 6px; padding: 14px; max-height: 180px; overflow-y: auto; font-size: 12px; color: #555; line-height: 1.6; margin-bottom: 12px; background: #fafafa;">
                        <strong>AVISO DE PRIVACIDAD PARA FORMULARIO DE REGISTRO EN LA BOLSA DE EMPLEO</strong><br><br>
                        LA INSTITUCIÓN UNIVERSITARIA ITM, en adelante ITM, le informa que los datos e información personal que se recolectan a través del presente formulario serán tratados con la finalidad principal de realizar acciones de intermediación laboral, otorgándole el acceso a una plataforma que le permitirá acceder a la bolsa de empleo del Gobierno nacional; en tal sentido con el fin de complementar su información, EL ITM podrá realizar análisis ocupacional basado en los datos personales que tiene bajo su custodia; crear herramientas que permitan dar una orientación más certera sobre su perfil ocupacional, todo ello conforme los criterios definidos por el Servicio Público de Empleo y por el Ministerio del Trabajo, de conformidad con los términos y exigencias de la Ley 1636 y el Decreto 2852 de 2013.<br><br>
                        En este sentido le indicamos que EL ITM obra únicamente como un intermediario que quiere apoyar a sus estudiantes y egresados en la búsqueda de ofertas laborales que se ajusten con sus perfiles ocupacionales y que por ende no puede garantizar ni decide directamente sobre el otorgamiento o no del empleo al cual se aspire por el solicitante.<br><br>
                        Le invitamos a consultar nuestra Política de Privacidad en: <a href="https://www.itm.edu.co/wp-content/uploads/legales/2023/politica-tratamiento-datos-ITM.pdf" target="_blank" style="color: #1a3c6e;">Política de Privacidad ITM</a><br><br>
                        Así mismo, acepta el tratamiento de datos por parte del Servicio Público de Empleo, en atención a su política dispuesta en: <a href="https://www.serviciodeempleo.gov.co/wp-content/uploads/2025/08/RESOLUCION-0429-ANEXO-POLITICA-DE-TRATAMIENTO-DE-DATOS.pdf" target="_blank" style="color: #1a3c6e;">Política de Tratamiento de Datos SPE</a>
                    </div>
                    <div class="checkbox-group" style="margin-bottom: 16px;">
                        <input type="checkbox" name="acepta_terminos" id="acepta_terminos" value="1" oninvalid="this.setCustomValidity('Debe aceptar el tratamiento de datos personales del ITM')" oninput="this.setCustomValidity('')" {{ old('acepta_terminos') ? 'checked' : '' }}>
                        <label for="acepta_terminos">Acepto el tratamiento de datos personales del ITM <span class="required">*</span></label>
                    </div>
                    @error('acepta_terminos') <span class="error-msg">{{ $message }}</span> @enderror

                    <div style="margin-top: 16px; padding-top: 16px; border-top: 1px solid #eee;">
                        <p style="font-size: 13px; color: #444; margin-bottom: 8px; font-weight: 600;">¿Acepta términos y condiciones?</p>
                        <p style="font-size: 13px; color: #555; margin-bottom: 12px;">Ver términos y condiciones en: <a href="https://personas.serviciodeempleo.gov.co/Adjuntos/Terminos%20y%20Condiciones%20201601%20V%201.0.pdf" target="_blank" style="color: #1a3c6e;">https://personas.serviciodeempleo.gov.co</a></p>
                        <div class="checkbox-group">
                            <input type="checkbox" name="acepta_terminos_spe" id="acepta_terminos_spe" value="1" oninvalid="this.setCustomValidity('Debe aceptar los términos y condiciones del SPE')" oninput="this.setCustomValidity('')" {{ old('acepta_terminos_spe') ? 'checked' : '' }}>
                            <label for="acepta_terminos_spe">Sí Acepto <span class="required">*</span></label>
                        </div>
                        @error('acepta_terminos_spe') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
 
                <button type="submit" class="btn-submit">Enviar pre-registro</button>
</form>
</div>
</div>
 
    <footer class="footer">
<p>Instituto Tecnológico Metropolitano &mdash; Programa de Egresados</p>
<p>Campus Fraternidad</p>
</footer>
 
    <script>
    document.querySelectorAll('input:not([type="checkbox"]):not([type="date"])').forEach(function(input) {
        input.setAttribute('autocomplete', 'one-time-code');
        input.setAttribute('readonly', true);
        input.addEventListener('focus', function() {
            this.removeAttribute('readonly');
        });
    });
    document.querySelectorAll('select').forEach(function(select) {
        select.setAttribute('autocomplete', 'one-time-code');
    });
</script>
 
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('/api/paises')
            .then(function(response) { return response.json(); })
            .then(function(paises) {
                var selectPais = document.getElementById('pais');
                paises.forEach(function(pais) {
                    var option = document.createElement('option');
                    option.value = pais.nombre;
                    option.textContent = pais.nombre;
                    option.setAttribute('data-id', pais.id);
                    selectPais.appendChild(option);
                });
 
                var paisAnterior = '{{ old("pais") }}';
                if (paisAnterior) {
                    selectPais.value = paisAnterior;
                    cambiarPais(paisAnterior);
                }
            });
    });
 
    function cambiarPais(paisNombre) {
        var selectPais = document.getElementById('pais');
        var filaDepartamentoMunicipio = document.getElementById('fila-departamento-municipio');
        var selectDepartamento = document.getElementById('departamento');
        var selectMunicipio = document.getElementById('municipio');
 
        selectDepartamento.innerHTML = '<option value="">Seleccione un departamento</option>';
        selectMunicipio.innerHTML = '<option value="">Seleccione un municipio</option>';
 
        if (paisNombre === 'Colombia') {
            filaDepartamentoMunicipio.style.display = 'grid';
            selectDepartamento.setAttribute('required', 'required');
            selectMunicipio.setAttribute('required', 'required');
 
            var selectedOption = selectPais.options[selectPais.selectedIndex];
            var paisId = selectedOption.getAttribute('data-id');
 
            fetch('/api/departamentos/' + paisId)
                .then(function(response) { return response.json(); })
                .then(function(departamentos) {
                    departamentos.forEach(function(dep) {
                        var option = document.createElement('option');
                        option.value = dep.nombre;
                        option.textContent = dep.nombre;
                        option.setAttribute('data-id', dep.id);
                        selectDepartamento.appendChild(option);
                    });
 
                    var depAnterior = '{{ old("departamento") }}';
                    if (depAnterior) {
                        selectDepartamento.value = depAnterior;
                        cambiarDepartamento(depAnterior);
                    }
                });
        } else {
            filaDepartamentoMunicipio.style.display = 'none';
            selectDepartamento.removeAttribute('required');
            selectMunicipio.removeAttribute('required');
            selectDepartamento.value = '';
            selectMunicipio.value = '';
        }
    }
 
    function cambiarDepartamento(depNombre) {
        var selectDepartamento = document.getElementById('departamento');
        var selectMunicipio = document.getElementById('municipio');
 
        selectMunicipio.innerHTML = '<option value="">Seleccione un municipio</option>';
 
        if (depNombre) {
            var selectedOption = selectDepartamento.options[selectDepartamento.selectedIndex];
            var depId = selectedOption.getAttribute('data-id');
 
            fetch('/api/municipios/' + depId)
                .then(function(response) { return response.json(); })
                .then(function(municipios) {
                    municipios.forEach(function(mun) {
                        var option = document.createElement('option');
                        option.value = mun.nombre;
                        option.textContent = mun.nombre;
                        selectMunicipio.appendChild(option);
                    });
 
                    var munAnterior = '{{ old("municipio") }}';
                    if (munAnterior) {
                        selectMunicipio.value = munAnterior;
                    }
                });
        }
    }
</script>
 
</body>
</html>