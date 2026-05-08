<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>

        body { font-family: 'Segoe UI', sans-serif; background: #f5f5f5; margin: 0; padding: 20px; }

        .container { max-width: 600px; margin: 0 auto; background: white; border-radius: 10px; overflow: hidden; border: 1px solid #e0e0e0; }

        .header { background: #1a3c6e; color: white; padding: 24px; text-align: center; }

        .header h1 { font-size: 20px; margin: 0; font-weight: 500; }

        .body { padding: 30px; }

        .badge { display: inline-block; background: #FAEEDA; color: #633806; padding: 6px 16px; border-radius: 16px; font-size: 14px; font-weight: 600; margin-bottom: 16px; }

        .body h2 { color: #1a3c6e; font-size: 20px; margin-bottom: 8px; }

        .body p { color: #555; line-height: 1.7; font-size: 14px; margin-bottom: 12px; }

        .info-box { background: #FAEEDA; padding: 16px; border-radius: 8px; color: #854F0B; font-size: 13px; line-height: 1.6; margin: 20px 0; }

        .alerta-box { background: #fee2e2; padding: 16px; border-radius: 8px; color: #991b1b; font-size: 13px; line-height: 1.6; margin: 20px 0; }

        .datos { background: #f9f9f9; padding: 16px; border-radius: 8px; margin: 20px 0; }

        .datos p { margin: 4px 0; font-size: 13px; color: #444; }

        .datos strong { color: #1a3c6e; }

        .spe-box { background: #E6F1FB; padding: 24px 20px; border-radius: 8px; margin: 20px 0; }

        .spe-box h3 { color: #0C447C; font-size: 16px; margin: 0 0 10px; }

        .spe-box p { color: #185FA5; font-size: 13px; line-height: 1.6; margin: 0 0 14px; }

        .spe-box ul { list-style: none; padding: 0; margin: 0 0 18px; }

        .spe-box ul li { color: #0C447C; font-size: 13px; padding: 4px 0 4px 16px; position: relative; }

        .spe-box ul li::before { content: ''; position: absolute; left: 0; top: 11px; width: 6px; height: 6px; background: #185FA5; border-radius: 50%; }

        .btn-spe { display: block; background: #0C447C; color: white; text-align: center; padding: 14px 20px; border-radius: 6px; font-size: 14px; font-weight: 600; text-decoration: none; margin: 0 0 10px; }

        .spe-link { display: block; text-align: center; color: #185FA5; font-size: 12px; }

        .footer { background: #f5f5f5; padding: 16px; text-align: center; font-size: 12px; color: #888; }
</style>
</head>
<body>
<div class="container">
<div class="header">
<h1>ITM - Bolsa de empleo</h1>
</div>
<div class="body">
<span class="badge">Usuario externo</span>
<h2>Resultado del pre-registro</h2>
<p>Hola {{ $usuario->primer_nombre }} {{ $usuario->primer_apellido }},</p>
<p>Hemos recibido su solicitud de pre-registro en el sistema de la Bolsa de Empleo del ITM. Sin embargo, su documento no fue encontrado en el Sistema de Información Académica (SIA), por lo que no ha sido posible vincularlo como estudiante activo o egresado.</p>
<div class="datos">
<p><strong>Documento:</strong> {{ $usuario->numero_documento }}</p>
<p><strong>Correo:</strong> {{ $usuario->correo }}</p>
<p><strong>Tipo de usuario ITM:</strong> No pertenece al ITM</p>
</div>
<div class="info-box">

                Este sistema está dirigido exclusivamente a estudiantes activos y egresados del ITM. Si desea acceder a oportunidades laborales, puede registrarse directamente en el Servicio Público de Empleo (SPE).
</div>
<div class="alerta-box">

                Si usted es estudiante activo o egresado del ITM pero el sistema lo clasificó como externo, por favor redacte lo sucedido al correo: <strong><a href="mailto:elmundodeltrabajo@itm.edu.co" style="color: #991b1b;">elmundodeltrabajo@itm.edu.co</a></strong> para darle solución.
</div>
<div class="spe-box">
<h3>Regístrese en el Servicio Público de Empleo</h3>
<p>Puede continuar su proceso de búsqueda de empleo registrándose en el portal del SPE. Le recomendamos hacerlo a través de alguno de los siguientes prestadores autorizados:</p>
<ul>
<li>Comfama</li>
<li>Alcaldía de Medellín</li>
<li>Comfenalco Antioquia</li>
</ul>
<a href="https://personas.serviciodeempleo.gov.co/" class="btn-spe">Ir al portal del SPE</a>
<span class="spe-link">https://personas.serviciodeempleo.gov.co/</span>
</div>
</div>
<div class="footer">
<p>Instituto Tecnológico Metropolitano &mdash; Programa de Egresados</p>
<p>Campus Fraternidad &mdash; {{ date('Y') }}</p>
<p>Este es un correo automático, por favor no responda a este mensaje.</p>
</div>
</div>
</body>
</html>
 