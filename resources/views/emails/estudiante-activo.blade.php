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
        .badge { display: inline-block; background: #d1fae5; color: #065f46; padding: 6px 16px; border-radius: 16px; font-size: 14px; font-weight: 600; margin-bottom: 16px; }
        .body h2 { color: #1a3c6e; font-size: 20px; margin-bottom: 8px; }
        .body p { color: #555; line-height: 1.7; font-size: 14px; margin-bottom: 12px; }
        .info-box { background: #d1fae5; padding: 16px; border-radius: 8px; color: #065f46; font-size: 13px; line-height: 1.6; margin: 20px 0; }
        .datos { background: #f9f9f9; padding: 16px; border-radius: 8px; margin: 20px 0; }
        .datos p { margin: 4px 0; font-size: 13px; color: #444; }
        .datos strong { color: #1a3c6e; }
        .footer { background: #f5f5f5; padding: 16px; text-align: center; font-size: 12px; color: #888; }
</style>
</head>
<body>
<div class="container">
<div class="header">
<h1>ITM - Bolsa de empleo</h1>
</div>
<div class="body">
<span class="badge">Estudiante activo</span>
<h2>Pre-registro exitoso</h2>
<p>Hola {{ $usuario->primer_nombre }} {{ $usuario->primer_apellido }},</p>
<p>Tu pre-registro en el sistema de la Bolsa de Empleo del ITM ha sido procesado exitosamente. Tu estado académico ha sido verificado con el Sistema de Información Académica (SIA) y has sido clasificado como <strong>estudiante activo</strong>.</p>
<div class="datos">
<p><strong>Documento:</strong> {{ $usuario->numero_documento }}</p>
<p><strong>Correo:</strong> {{ $usuario->correo }}</p>
<p><strong>Estado:</strong> Estudiante activo</p>
<p><strong>Fecha de registro:</strong> {{ $usuario->created_at->format('d/m/Y H:i') }}</p>
</div>
<div class="info-box">
                Tu información será gestionada por la Oficina de Egresados ante el Servicio Público de Empleo (SPE). Este es el primer paso; una vez procesada tu información, deberás continuar el proceso directamente en el portal del SPE.
</div>
</div>
<div class="footer">
<p>Instituto Tecnológico Metropolitano &mdash; Oficina de Egresados</p>
<p>Campus Fraternidad &mdash; {{ date('Y') }}</p>
<p>Este es un correo automático, por favor no responda a este mensaje.</p>
</div>
</div>
</body>
</html>