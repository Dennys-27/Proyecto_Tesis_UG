<?php
require_once("config/conexion.php");

if (isset($_POST["enviar"]) && $_POST["enviar"] == "si") {
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
                        $mensaje = "El usuario o correo ya existe";
                        break;
                    case "2":
                        $mensaje = "Los campos están vacíos o el rol no fue seleccionado";
                        break;
                    default:
                        $mensaje = "Error desconocido";
                }

                if ($mensaje !== "") {
            ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="miAlerta">
                        <strong><i class="bi bi-exclamation-triangle-fill me-2"></i></strong>
                        <?= htmlspecialchars($mensaje) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
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

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Usuario</label>
                    <input type="text" class="form-control" id="usuario" name="usuario"
                        value="<?= isset($_POST['usuario']) ? htmlspecialchars($_POST['usuario']) : '' ?>"
                        placeholder="Ingresa tu Nombre de Usuario" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombres" name="nombres"
                        value="<?= isset($_POST['nombres']) ? htmlspecialchars($_POST['nombres']) : '' ?>"
                        placeholder="Ingresa tu Nombre" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Apellido</label>
                    <input type="text" class="form-control" id="apellidos" name="apellidos"
                        value="<?= isset($_POST['apellidos']) ? htmlspecialchars($_POST['apellidos']) : '' ?>"
                        placeholder="Ingresa tu Apellido" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control" id="usu_correo" name="correo"
                        value="<?= isset($_POST['correo']) ? htmlspecialchars($_POST['correo']) : '' ?>"
                        placeholder="Ingresa tu Correo" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Identificación</label>
                    <input type="text" class="form-control" id="cedula" name="cedula"
                        value="<?= isset($_POST['cedula']) ? htmlspecialchars($_POST['cedula']) : '' ?>"
                        placeholder="Ingresa tu Cédula" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Contraseña</label>
                    <input type="password" id="clave" name="clave" class="form-control"
                        placeholder="Ingrese su contraseña" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Rol</label>
                    <select id="rol" name="rol" class="form-control" required>
                        <option value="">Seleccione un rol</option>
                    </select>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <input type="hidden" name="enviar" value="si">
                <button type="submit" class="btn btn-login text-white flex-fill">Registrar</button>
                <a href="index.php" class="btn btn-register flex-fill text-center">Volver al login</a>
            </div>
        </form>
    </div>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/app.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            fetch("controller/rol.php?op=combo")
                .then(res => res.json())
                .then(data => {
                    let select = document.getElementById("rol");
                    select.innerHTML = `<option value="">Seleccione un rol</option>`;
                    data.forEach(item => {
                        select.innerHTML += `<option value="${item.id_rol}">${item.nombre}</option>`;
                    });
                })
                .catch(err => {
                    console.error("Error al cargar los roles:", err);
                });
        });
    </script>
</body>

</html>
