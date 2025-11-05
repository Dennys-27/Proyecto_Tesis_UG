<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Recuperar Contraseña - Sistema de Gestión</title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="assets/css/estilos.css" />

</head>
<body>
  <!-- Se enfoca en la recuperacion de contraseñas de usuarios -->

  <div class="card shadow login-card p-4">
    <div class="d-flex justify-content-between align-items-center mb-4 login-header">
      <div class="logo">
        <img src="assets/img/Logo-UG-2016.png" alt="UG Logo" style="max-width:80px; height:auto; object-fit:contain;" />
      </div>
      <div class="separator"></div>
      <div class="login-title">
        Recuperar contraseña <br/> Sistema de gestión
      </div>
    </div>

    <form onsubmit="return false;">
      <div class="mb-3">
        <label for="email" class="form-label">Correo electrónico</label>
        <input type="email" id="email" class="form-control" placeholder="Ingrese su correo" autocomplete="email" />
      </div>

      <button type="button" id="btnEnviarCorreo" class="btn btn-login text-white w-100">Enviar instrucciones</button>
      <a href="index.html" class="btn btn-register w-100 mt-2 text-center">Volver al login</a>
    </form>
  </div>

  <!-- Icono animado: SVG de sobre (evita imágenes externas grandes) -->
  <div id="correoAnimado" aria-hidden="true">
    <svg viewBox="0 0 24 24" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true">
      <rect x="1.5" y="5" rx="2" ry="2" width="21" height="13" fill="white" opacity="0.95"></rect>
      <polyline points="2.5,7.5 12,13.5 21.5,7.5" fill="none" stroke="#3b57f9" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
  </div>

  <!-- modal -->
  <div class="modal fade" id="correoModal" tabindex="-1" aria-labelledby="correoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content text-center">
        <div class="modal-body">
          <div id="loadingSpinner" class="mb-3">
            <div class="spinner-border text-primary" role="status" aria-hidden="true"></div>
            <p>Enviando correo...</p>
          </div>

          <div id="successMessage" class="d-none" role="status" aria-live="polite">
            <!-- svg envelope with check -->
            <svg class="success-envelope" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <rect x="4" y="12" width="56" height="40" rx="6" fill="#e9f0ff" />
              <polyline points="12,20 32,36 52,16" fill="none" stroke="#1f7bff" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
              <path d="M8 18 L32 36 L56 18" stroke="#cfe3ff" stroke-width="2" fill="none" />
            </svg>

            <h5 class="text-success">Correo enviado correctamente</h5>
            <p class="msg">Revisa tu bandeja de entrada para restablecer tu contraseña.</p>
            <button type="button" class="btn btn-login mt-2" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- burst container (created dynamically) -->
  <div id="burstRoot"></div>

  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/app.js"></script> <!-- opcional: fondo animado -->

  
</body>
</html>
