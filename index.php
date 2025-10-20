<?php
require_once("config/conexion.php");
if (isset($_POST["enviar"]) and $_POST["enviar"] == "si") {
    require_once("models/Login.php");
    $login = new Login();
    $login->login();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Gestión</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>

<body>

    <div class="card shadow login-card p-4">
        <div class="d-flex justify-content-between align-items-center mb-4 login-header">
            <div class="logo">
                <img src="assets/img/Logo-UG-2016.png" alt="UG Logo">
            </div>
            <div class="separator"></div>
            <div class="login-title">
                Sistema de gestión de <br> Proyectos Curriculares de Ingeniería de Software
            </div>
        </div>

        <form class="sign-box" action="" method="post" id="login_form">
            <?php
            if (isset($_GET["m"])) {
                $mensaje = "";
                switch ($_GET["m"]) {
                    case "1":
                        $mensaje = "El usuario o contraseña son incorrectos";
                        break;
                    case "2":
                        $mensaje = "Los campos están vacíos";
                        break;
                    default:
                        $mensaje = "Error desconocido";
                }

                if ($mensaje !== "") {
            ?>
                    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert" id="miAlerta">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>

                    <script>
                        setTimeout(() => {
                            const alerta = document.getElementById('miAlerta');
                            if (alerta) {
                                alerta.classList.remove('show');
                                alerta.classList.add('fade');
                                setTimeout(() => alerta.remove(), 500);
                            }
                        }, 5000);
                    </script>
            <?php
                }
            }
            ?>

            <div class="mb-3">
                <label for="cedula" class="form-label fw-semibold">Cédula</label>
                <input type="text" class="form-control" id="cedula" name="cedula"
                    placeholder="Ingresa tu cédula"
                    value="<?= isset($_POST['cedula']) ? htmlspecialchars($_POST['cedula'], ENT_QUOTES, 'UTF-8') : '' ?>">
            </div>

            <div class="mb-4">
                <label for="clave" class="form-label fw-semibold">Contraseña</label>
                <input type="password" id="clave" name="clave" class="form-control"
                    placeholder="Ingresa tu contraseña">
            </div>

            <div class="d-grid gap-2">
                <button type="submit" name="enviar" value="si" class="btn btn-primary btn-lg">
                    Ingresar
                </button>
                <a href="registrar.php" class="btn btn-outline-secondary btn-lg">
                    Registrar
                </a>
            </div>

            <div class="text-center mt-3">
                <a href="recuperar.php" class="small text-decoration-none">¿Olvidó su contraseña?</a>
            </div>
        </form>

    </div>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/app.js"></script>
</body>

</html>