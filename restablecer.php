<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Restablecer Contraseña - Sistema de Gestión</title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="assets/css/estilos.css" />
  <style>
   
  </style>
</head>
<body>
  <div class="card shadow login-card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3 login-header">
      <div class="logo">
        <img src="assets/img/Logo-UG-2016.png" alt="UG Logo" style="height:auto; object-fit:contain;">
      </div>
      <div class="separator"></div>
      <div class="login-title">
        Restablecer contraseña<br><small style="opacity:.85">Sistema de gestión — Ingeniería de Software</small>
      </div>
    </div>

    <form id="resetForm" onsubmit="return false;">
      <input type="hidden" id="token" value="" />

      <div class="mb-3 pw-group">
        <label for="pw1" class="form-label">Nueva contraseña</label>
        <input type="password" id="pw1" class="form-control" placeholder="Mínimo 8 caracteres" autocomplete="new-password" />
        <button type="button" class="pw-toggle" id="togglePw1" aria-label="Mostrar/ocultar contraseña 1" title="Mostrar/ocultar">
          <!-- eye closed (default) -->
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M2 2l20 20" />
            <path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-5 0-9.27-3.11-11-8 1.05-2.76 2.9-4.96 5.09-6.3" />
            <path d="M9.53 9.54a3.5 3.5 0 0 0 4.92 4.92" />
          </svg>
        </button>
        <div id="pw1Help" class="form-text">Mínimo 8 caracteres, una mayúscula y un número.</div>
      </div>

      <div class="mb-3 pw-group">
        <label for="pw2" class="form-label">Confirmar contraseña</label>
        <input type="password" id="pw2" class="form-control" placeholder="Confirma la contraseña" autocomplete="new-password" />
        <button type="button" class="pw-toggle" id="togglePw2" aria-label="Mostrar/ocultar contraseña 2" title="Mostrar/ocultar">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M2 2l20 20" />
            <path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-5 0-9.27-3.11-11-8 1.05-2.76 2.9-4.96 5.09-6.3" />
            <path d="M9.53 9.54a3.5 3.5 0 0 0 4.92 4.92" />
          </svg>
        </button>
        <div id="pw2Help" class="form-text error d-none">Las contraseñas no coinciden</div>
      </div>

      <div class="d-grid gap-2">
        <button type="button" id="btnRestablecer" class="btn btn-login text-white">Restablecer contraseña</button>
      </div>

      <div class="text-center mt-3">
        <a href="index.html" class="small text-white">Volver al login</a>
      </div>
    </form>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="restModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content text-center p-4">
        <div class="modal-body">
          <div id="restLoading" class="mb-3">
            <div class="spinner-border text-primary" role="status" aria-hidden="true"></div>
            <p class="mt-2">Aplicando cambios...</p>
          </div>

          <div id="restSuccess" class="d-none">
            <svg class="success-check" viewBox="0 0 64 64" width="64" height="64" aria-hidden="true">
              <circle cx="32" cy="32" r="30" fill="#e9f5ff"/>
              <polyline points="18,34 28,44 46,22" fill="none" stroke="#1f7bff" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <h5 class="text-success">Contraseña restablecida</h5>
            <p class="mb-2">Ya puedes iniciar sesión con tu nueva contraseña.</p>
            <a href="index.html" class="btn btn-login">Ir al login</a>
          </div>

          <div id="restError" class="d-none">
            <h5 class="text-danger">Error</h5>
            <p class="mb-2">No se pudo restablecer la contraseña. Intenta de nuevo.</p>
            <button type="button" class="btn btn-register" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/app.js"></script> <!-- si usas fondo animado -->

  
</body>
</html>
