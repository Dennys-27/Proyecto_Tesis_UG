<?php
require_once("config/conexion.php");
if (isset($_POST["enviar"]) and $_POST["enviar"] == "si") {
    # code...
    require_once("models/Login.php");
    $login = new Login();
    $login->register();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar - Sistema de Gestión</title>
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
                Crear nueva cuenta <br> Sistema de gestión
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

                    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="miAlerta">
                        <strong><i class="bi bi-exclamation-triangle-fill me-2"></i></strong>
                        <?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                <label for="usuario" class="form-label">Usuario </label>
                <input type="text" class="form-control" id="usuario" name="usuario"
                    value="<?= isset($_POST['usuario']) ? htmlspecialchars($_POST['usuario'], ENT_QUOTES, 'UTF-8') : '' ?>"
                    placeholder="Ingresa tu Nombre de Usuario">
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre </label>
                <input type="text" class="form-control" id="nombres" name="nombres"
                    value="<?= isset($_POST['nombres']) ? htmlspecialchars($_POST['nombres'], ENT_QUOTES, 'UTF-8') : '' ?>"
                    placeholder="Ingresa tu Nombre">
            </div>
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos"
                    value="<?= isset($_POST['apellidos']) ? htmlspecialchars($_POST['apellidos'], ENT_QUOTES, 'UTF-8') : '' ?>"
                    placeholder="Ingresa tu Apellido">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="text" class="form-control" id="usu_correo" name="correo"
                    value="<?= isset($_POST['correo']) ? htmlspecialchars($_POST['correo'], ENT_QUOTES, 'UTF-8') : '' ?>"
                    placeholder="Ingresa tu Correo">
            </div>
            <div class="mb-3">
                <label for="cedula" class="form-label">Identificacion</label>
                <input type="text" class="form-control" id="cedula" name="cedula"
                    value="<?= isset($_POST['cedula']) ? htmlspecialchars($_POST['cedula'], ENT_QUOTES, 'UTF-8') : '' ?>"
                    placeholder="Ingresa tu Cedula">
            </div>
            <div class="mb-3">
                <label for="clave" class="form-label">Contraseña</label>
                <input type="password" id="clave" name="clave" class="form-control" placeholder="Ingrese su contraseña">
            </div>

            <div class="d-flex gap-2">
                <input type="hidden" name="enviar" value="si" class="form-control">
                <button type="submit" class="btn btn-login text-white flex-fill">Registrar</button>
                <a href="index.php" class="btn btn-register flex-fill text-center">Volver al login</a>
            </div>
        </form>

    </div>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/app.js"></script>
</body>

</html>