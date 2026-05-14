<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ITM - Bolsa de empleo</title>
<style>

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body { font-family: 'Segoe UI', sans-serif; background: #f5f5f5; color: #333; }
 
        .header { background: #1a3c6e; color: white; padding: 18px 40px; display: flex; justify-content: space-between; align-items: center; }

        .header h1 { font-size: 20px; font-weight: 500; }

        .header nav a { color: white; text-decoration: none; margin-left: 24px; font-size: 14px; opacity: 0.85; }

        .header nav a:hover { opacity: 1; text-decoration: underline; }
 
        .hero { background: #1a3c6e; color: white; text-align: center; padding: 70px 20px 60px; }

        .hero h2 { font-size: 34px; font-weight: 600; margin-bottom: 14px; }

        .hero p { font-size: 15px; max-width: 680px; margin: 0 auto 28px; line-height: 1.7; opacity: 0.9; }

        .btn-primary { background: #e8a820; color: #1a3c6e; padding: 14px 36px; border: none; border-radius: 6px; font-size: 16px; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-block; transition: background 0.2s; }

        .btn-primary:hover { background: #d4951a; }
 
        .section { max-width: 960px; margin: 0 auto; padding: 50px 20px; }

        .section-title { font-size: 24px; font-weight: 600; text-align: center; color: #1a3c6e; margin-bottom: 10px; }

        .section-subtitle { font-size: 15px; text-align: center; color: #666; margin-bottom: 32px; line-height: 1.6; }
 
        .bg-white { background: white; }

        .bg-gray { background: #f5f5f5; }
 
        .info-card { background: #E6F1FB; border-radius: 10px; padding: 24px 28px; max-width: 700px; margin: 0 auto 32px; }

        .info-card h4 { font-size: 15px; font-weight: 600; color: #0C447C; margin-bottom: 10px; }

        .info-card p { font-size: 13px; color: #185FA5; line-height: 1.7; margin-bottom: 8px; }

        .info-card a { color: #0C447C; font-weight: 600; }
 
        .perfiles-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; max-width: 600px; margin: 0 auto; }

        .perfil-card { border-radius: 10px; padding: 30px 24px; text-align: center; }

        .perfil-card.estudiante { background: #E6F1FB; }

        .perfil-card.egresado { background: #E1F5EE; }

        .perfil-icon { width: 50px; height: 50px; border-radius: 50%; margin: 0 auto 14px; display: flex; align-items: center; justify-content: center; }

        .perfil-card.estudiante .perfil-icon { background: #B5D4F4; }

        .perfil-card.egresado .perfil-icon { background: #9FE1CB; }

        .perfil-card h4 { font-size: 17px; font-weight: 600; margin-bottom: 8px; }

        .perfil-card.estudiante h4 { color: #0C447C; }

        .perfil-card.egresado h4 { color: #085041; }

        .perfil-card p { font-size: 14px; line-height: 1.6; }

        .perfil-card.estudiante p { color: #185FA5; }

        .perfil-card.egresado p { color: #0F6E56; }
 
        .banner-externo { background: #FAEEDA; border-radius: 10px; padding: 20px 24px; max-width: 600px; margin: 24px auto 0; display: flex; align-items: flex-start; gap: 16px; }

        .banner-externo-icon { width: 42px; height: 42px; background: #FAC775; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 2px; }

        .banner-externo h4 { font-size: 15px; font-weight: 600; color: #633806; margin-bottom: 4px; }

        .banner-externo p { font-size: 13px; color: #854F0B; line-height: 1.6; }
 
        .pasos-list { display: flex; flex-direction: column; gap: 14px; max-width: 700px; margin: 0 auto; }

        .paso-item { display: flex; align-items: center; gap: 16px; background: white; border-radius: 10px; padding: 18px 22px; border: 1px solid #e8e8e8; }

        .paso-numero { width: 40px; height: 40px; background: #1a3c6e; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 16px; font-weight: 600; flex-shrink: 0; }

        .paso-item h4 { font-size: 15px; font-weight: 600; color: #1a3c6e; margin-bottom: 3px; }

        .paso-item p { font-size: 13px; color: #666; line-height: 1.5; }
 
        .faq-list { display: flex; flex-direction: column; gap: 12px; max-width: 700px; margin: 0 auto; }

        .faq-item { border: 1px solid #e8e8e8; border-radius: 10px; padding: 18px 22px; background: white; }

        .faq-item h4 { font-size: 15px; font-weight: 600; color: #1a3c6e; margin-bottom: 6px; }

        .faq-item p { font-size: 13px; color: #666; line-height: 1.6; }
 
        .footer { background: #1a3c6e; color: white; text-align: center; padding: 24px 20px; }

        .footer p { font-size: 13px; opacity: 0.8; margin-bottom: 4px; }

        .footer p:last-child { opacity: 0.6; font-size: 12px; margin-bottom: 0; }
 
        @media (max-width: 600px) {

            .header { padding: 14px 20px; flex-direction: column; gap: 10px; }

            .hero h2 { font-size: 26px; }

            .perfiles-grid { grid-template-columns: 1fr; }

            .banner-externo { flex-direction: column; align-items: center; text-align: center; }

        }
</style>
</head>
<body>
 
    <header class="header">
<h1>ITM - Bolsa de empleo</h1>
<nav>
<a href="/">Inicio</a>
<a href="/pre-registro">Pre-registro</a>
<a href="/admin/login">Administración</a>
</nav>
</header>
 
    <section class="hero">
<h2>El primer paso hacia nuevas oportunidades</h2>
<p>Con el diligenciamiento de este formulario se brinda la información para que el ITM proceda a realizar la creación de su cuenta de usuario como buscador de empleo en la plataforma del Sistema de Información del Servicio de Empleo (SISE), donde la Institución Universitaria ITM oficiará como Prestador de su Preferencia.</p>
<a href="/pre-registro" class="btn-primary">Iniciar Pre-registro</a>
</section>
 
    <section class="section bg-white">
<div class="info-card">
<h4>¿Qué sucede después del pre-registro?</h4>
<p>Una vez el ITM haya creado la cuenta de usuario, al correo electrónico registrado llegará un mensaje de bienvenida de parte de <strong>sise@serviciodeempleo.gov.co</strong> en el cual se le indicarán las credenciales (usuario y contraseña) de acceso al sistema.</p>
<p>Luego, para una correcta utilización de este servicio deberá ingresar al Sistema a través de <a href="https://personas.serviciodeempleo.gov.co" target="_blank">https://personas.serviciodeempleo.gov.co</a> y completar toda la información solicitada en la hoja de vida.</p>
<p>Tenga en cuenta que del nivel de completitud de la hoja de vida, así como de la veracidad de la información allí consignada, dependerá el éxito de la búsqueda laboral.</p>
</div>
 
        <h3 class="section-title">¿Quién puede aplicar?</h3>
<p class="section-subtitle">Este sistema está dirigido a la comunidad académica del Instituto Tecnológico Metropolitano.</p>
<div class="perfiles-grid">
<div class="perfil-card estudiante">
<div class="perfil-icon">
<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0C447C" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
</div>
<h4>Estudiantes activos</h4>
<p>Personas matriculadas actualmente en cualquier programa académico del ITM.</p>
</div>
<div class="perfil-card egresado">
<div class="perfil-icon">
<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#085041" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
</div>
<h4>Egresados</h4>
<p>Graduados de programas académicos del Instituto Tecnológico Metropolitano.</p>
</div>
</div>
 
        <div class="banner-externo">
<div class="banner-externo-icon">
<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#633806" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
</div>
<div>
<h4>¿No pertenece al ITM?</h4>
<p>Puede acceder directamente al Servicio Público de Empleo (SPE) para registrarse en su plataforma oficial de intermediación laboral.</p>
</div>
</div>
</section>
 
    <section class="section bg-gray">
<h3 class="section-title">Pasos del pre-registro</h3>
<p class="section-subtitle">El proceso es rápido, seguro y completamente en línea.</p>
<div class="pasos-list">
<div class="paso-item">
<div class="paso-numero">1</div>
<div>
<h4>Diligencie el formulario</h4>
<p>Complete sus datos personales conforme a los requisitos del Servicio Público de Empleo.</p>
</div>
</div>
<div class="paso-item">
<div class="paso-numero">2</div>
<div>
<h4>Validación académica automática</h4>
<p>El sistema verifica el Tipo de usuario ITM directamente con el Sistema de Información Académica del ITM (SIA).</p>
</div>
</div>
<div class="paso-item">
<div class="paso-numero">3</div>
<div>
<h4>Reciba la notificación</h4>
<p>Se le enviará un correo electrónico con el resultado del pre-registro y los pasos a seguir.</p>
</div>
</div>
<div class="paso-item">
<div class="paso-numero">4</div>
<div>
<h4>Gestión institucional</h4>
<p>El Programa de Egresados consolida y gestiona la información ante el Servicio Público de Empleo para la creación de la cuenta en el SISE.</p>
</div>
</div>
</div>
</section>
 
    <section class="section bg-white">
<h3 class="section-title">Preguntas frecuentes</h3>
<div class="faq-list">
<div class="faq-item">
<h4>¿Qué documentos necesito?</h4>
<p>Solo necesita su documento de identidad, un correo electrónico válido y su número de teléfono.</p>
</div>
<div class="faq-item">
<h4>¿Si no pertenezco al ITM y ya diligencié el pre-registro, qué sucede?</h4>
<p>Recibirá una notificación por correo electrónico con la orientación hacia los canales oficiales del Servicio Público de Empleo para que pueda continuar su proceso allí.</p>
</div>
<div class="faq-item">
<h4>¿Cuánto tarda la validación?</h4>
<p>La validación académica es automática e inmediata al momento de enviar el formulario de pre-registro.</p>
</div>
<div class="faq-item">
<h4>¿Mis datos están protegidos?</h4>
<p>Sí. El sistema cumple con la Ley 1581 de 2012 sobre protección de datos personales. Su información solo será utilizada para los fines del proceso de intermediación laboral ante el SPE.</p>
</div>
<div class="faq-item">
<h4>¿Qué es el SISE?</h4>
<p>Es el Sistema de Información del Servicio de Empleo, la plataforma del Gobierno Nacional donde se realizan todas las transacciones de buscadores de empleo, empresarios y prestadores del Servicio Público de Empleo.</p>
</div>
</div>
</section>
 
    <footer class="footer">
<p>Instituto Tecnológico Metropolitano &mdash; Programa de Egresados</p>
<p>Campus Fraternidad</p>
</footer>
 
</body>
</html>
 