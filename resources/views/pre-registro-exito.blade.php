<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registro exitoso - ITM Bolsa de empleo</title>
<style>

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body { font-family: 'Segoe UI', sans-serif; background: #f5f5f5; color: #333; }
 
        .header { background: #1a3c6e; color: white; padding: 18px 40px; display: flex; justify-content: space-between; align-items: center; }

        .header h1 { font-size: 20px; font-weight: 500; }
 
        .container { max-width: 600px; margin: 60px auto; padding: 0 20px; text-align: center; }
 
        .result-card {

            background: white;

            border-radius: 10px;

            padding: 50px 40px;

            box-shadow: 0 2px 8px rgba(0,0,0,0.06);

            border: 1px solid #e8e8e8;

        }
 
        .result-icon {

            width: 70px;

            height: 70px;

            border-radius: 50%;

            display: flex;

            align-items: center;

            justify-content: center;

            margin: 0 auto 24px;

        }

        .result-icon.success { background: #d1fae5; }

        .result-icon.warning { background: #FAEEDA; }
 
        .result-card h2 { color: #1a3c6e; margin-bottom: 14px; font-size: 22px; font-weight: 600; }

        .result-card p { color: #555; line-height: 1.7; margin-bottom: 12px; font-size: 14px; }
 
        .badges { margin: 16px 0; }

        .estado-badge {

            display: inline-block;

            padding: 8px 20px;

            border-radius: 20px;

            font-size: 14px;

            font-weight: 600;

            margin: 4px;

        }

        .estado-badge.activo { background: #d1fae5; color: #065f46; }

        .estado-badge.egresado { background: #E6F1FB; color: #0C447C; }

        .estado-badge.externo { background: #FAEEDA; color: #633806; }
 
        .datos-box {

            background: #f9f9f9;

            padding: 16px;

            border-radius: 8px;

            margin: 20px 0;

            text-align: left;

        }

        .datos-box p { margin: 4px 0; font-size: 13px; color: #444; }

        .datos-box strong { color: #1a3c6e; }
 
        .info-box {

            padding: 14px 18px;

            border-radius: 8px;

            font-size: 13px;

            line-height: 1.6;

            margin-top: 20px;

            text-align: left;

        }

        .info-box.success { background: #d1fae5; color: #065f46; }

        .info-box.warning { background: #FAEEDA; color: #854F0B; }
 
        .alerta-box {

            background: #fee2e2;

            padding: 14px 18px;

            border-radius: 8px;

            color: #991b1b;

            font-size: 13px;

            line-height: 1.6;

            margin-top: 16px;

            text-align: left;

        }

        .alerta-box a { color: #991b1b; font-weight: 600; }
 
        .spe-box {

            background: #E6F1FB;

            padding: 20px;

            border-radius: 8px;

            margin-top: 16px;

            text-align: left;

        }

        .spe-box h3 { color: #0C447C; font-size: 15px; margin: 0 0 8px; }

        .spe-box p { color: #185FA5; font-size: 13px; line-height: 1.6; margin: 0 0 12px; }

        .spe-box ul { list-style: none; padding: 0; margin: 0 0 14px; }

        .spe-box ul li { color: #0C447C; font-size: 13px; padding: 3px 0 3px 14px; position: relative; }

        .spe-box ul li::before { content: ''; position: absolute; left: 0; top: 10px; width: 5px; height: 5px; background: #185FA5; border-radius: 50%; }

        .btn-spe { display: block; background: #0C447C; color: white; text-align: center; padding: 12px 20px; border-radius: 6px; font-size: 14px; font-weight: 600; text-decoration: none; }
 
        .btn-home {

            background: #1a3c6e;

            color: white;

            padding: 12px 30px;

            border: none;

            border-radius: 6px;

            font-size: 14px;

            font-weight: 600;

            text-decoration: none;

            display: inline-block;

            margin-top: 24px;

            transition: background 0.2s;

        }

        .btn-home:hover { background: #15325a; }
 
        .footer { background: #1a3c6e; color: white; text-align: center; padding: 24px 20px; margin-top: 80px; }

        .footer p { font-size: 13px; opacity: 0.8; margin-bottom: 4px; }

        .footer p:last-child { opacity: 0.6; font-size: 12px; margin-bottom: 0; }
 
        @media (max-width: 600px) {

            .header { padding: 14px 20px; }

            .result-card { padding: 30px 20px; }

        }
</style>
</head>
<body>
 
    <header class="header">
<h1>ITM - Bolsa de empleo</h1>
</header>
 
    <div class="container">
<div class="result-card">
 
            @if(session('estado_academico') === 'estudiante_activo')
<div class="result-icon success">
<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
</div>
<h2>Pre-registro exitoso</h2>
<div class="badges"><span class="estado-badge activo">Estudiante activo</span></div>
<p>Su estado académico ha sido verificado con el Sistema de Información Académica del ITM (SIA) y ha sido clasificado como <strong>estudiante activo</strong>.</p>
<div class="datos-box">
<p><strong>Documento:</strong> {{ session('documento') }}</p>
<p><strong>Correo:</strong> {{ session('correo') }}</p>
<p><strong>Estado:</strong> Estudiante activo</p>
</div>
<div class="info-box success">

                    Su información será gestionada por el Programa de Egresados ante el Servicio Público de Empleo (SPE). Este es el primer paso; una vez procesada su información, deberá continuar el proceso directamente en el portal del SPE. Recibirá una notificación por correo electrónico con más información.
</div>
 
            @elseif(session('estado_academico') === 'egresado')
<div class="result-icon success">
<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
</div>
<h2>Pre-registro exitoso</h2>
<div class="badges"><span class="estado-badge egresado">Egresado</span></div>
<p>Su estado académico ha sido verificado con el Sistema de Información Académica del ITM (SIA) y ha sido clasificado como <strong>egresado</strong>.</p>
<div class="datos-box">
<p><strong>Documento:</strong> {{ session('documento') }}</p>
<p><strong>Correo:</strong> {{ session('correo') }}</p>
<p><strong>Estado:</strong> Egresado</p>
</div>
<div class="info-box success">

                    Su información será gestionada por el Programa de Egresados ante el Servicio Público de Empleo (SPE). Este es el primer paso; una vez procesada su información, deberá continuar el proceso directamente en el portal del SPE. Recibirá una notificación por correo electrónico con más información.
</div>
 
            @elseif(session('estado_academico') === 'egresado_activo')
<div class="result-icon success">
<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
</div>
<h2>Pre-registro exitoso</h2>
<div class="badges">
<span class="estado-badge egresado">Egresado</span>
<span class="estado-badge activo">Estudiante activo</span>
</div>
<p>Su estado académico ha sido verificado con el Sistema de Información Académica del ITM (SIA). Se ha identificado que usted es <strong>egresado</strong> y además <strong>estudiante activo</strong> del ITM.</p>
<div class="datos-box">
<p><strong>Documento:</strong> {{ session('documento') }}</p>
<p><strong>Correo:</strong> {{ session('correo') }}</p>
<p><strong>Estado:</strong> Egresado y estudiante activo</p>
</div>
<div class="info-box success">

                    Su información será gestionada por el Programa de Egresados ante el Servicio Público de Empleo (SPE). Este es el primer paso; una vez procesada su información, deberá continuar el proceso directamente en el portal del SPE. Recibirá una notificación por correo electrónico con más información.
</div>
 
            @elseif(session('estado_academico') === 'externo')
<div class="result-icon warning">
<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#854F0B" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
</div>
<h2>Resultado del pre-registro</h2>
<div class="badges"><span class="estado-badge externo">Usuario externo</span></div>
<p>Su documento no fue encontrado en el Sistema de Información Académica del ITM (SIA), por lo que no ha sido posible vincularlo como estudiante activo o egresado.</p>
<div class="datos-box">
<p><strong>Documento:</strong> {{ session('documento') }}</p>
<p><strong>Correo:</strong> {{ session('correo') }}</p>
<p><strong>Estado:</strong> No pertenece al ITM</p>
</div>
<div class="info-box warning">

                    Este sistema está dirigido exclusivamente a estudiantes activos y egresados del ITM. Si desea acceder a oportunidades laborales, puede registrarse directamente en el Servicio Público de Empleo (SPE).
</div>
<div class="alerta-box">

                    Si usted es estudiante activo o egresado del ITM pero el sistema lo clasificó como externo, por favor redacte lo sucedido al correo: <a href="mailto:elmundodeltrabajo@itm.edu.co">elmundodeltrabajo@itm.edu.co</a> para darle solución.
</div>
<div class="spe-box">
<h3>Regístrese en el Servicio Público de Empleo</h3>
<p>Puede continuar su proceso de búsqueda de empleo registrándose en el portal del SPE a través de alguno de los siguientes prestadores autorizados:</p>
<ul>
<li>Comfama</li>
<li>Alcaldía de Medellín</li>
<li>Comfenalco Antioquia</li>
</ul>
<a href="https://personas.serviciodeempleo.gov.co/" class="btn-spe">Ir al portal del SPE</a>
</div>
 
            @else
<div class="result-icon success">
<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
</div>
<h2>Pre-registro enviado</h2>
<p>Su información ha sido recibida correctamente. El sistema validará su estado académico y recibirá una notificación por correo electrónico con el resultado.</p>

            @endif
 
            <a href="/" class="btn-home">Volver al inicio</a>
</div>
</div>
 
    <footer class="footer">
<p>Instituto Tecnológico Metropolitano &mdash; Programa de Egresados</p>
<p>Campus Fraternidad &mdash; &copy; {{ date('Y') }}</p>
</footer>
 
</body>
</html>
 