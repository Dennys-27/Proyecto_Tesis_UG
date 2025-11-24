<?php
class Login extends Conectar
{
    public function login()
    {
        $conectar = parent::Conexion();
        parent::set_names();

        if (isset($_POST["enviar"])) {
            $cedula = trim($_POST["cedula"]);
            $clave = trim($_POST["clave"]);

            if (empty($cedula) || empty($clave)) {
                header("Location: " . conectar::ruta() . "index.php?m=2");
                exit();
            } else {
                // Buscar solo por cedula
                $sql = "SELECT * FROM usuario WHERE cedula = ? AND estado = 1";
                $stmt = $conectar->prepare($sql);
                $stmt->bindValue(1, $cedula);
                $stmt->execute();

                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($resultado) {
                    // Validar contraseña
                    if (password_verify($clave, $resultado["clave"])) {
                        $_SESSION["id_usuario"] = $resultado["id_usuario"];
                        $_SESSION["nombres"]   = $resultado["nombres"];
                        $_SESSION["apellidos"] = $resultado["apellidos"];
                        $_SESSION["cedula"]    = $resultado["cedula"];
                        $_SESSION["id_rol"]    = $resultado["id_rol"];

                        // Verificar rol y redirigir
                        if ($_SESSION["id_rol"] == 2) {
                            header("Location: " . conectar::ruta() . "views/MntTareas");
                        } else {
                            header("Location: " . conectar::ruta() . "views/home");
                        }
                        exit();

                    } else {
                        // Contraseña incorrecta
                        header("Location: " . conectar::ruta() . "index.php?m=1");
                        exit();
                    }
                } else {
                    // Usuario no encontrado
                    header("Location: " . conectar::ruta() . "index.php?m=1");
                    exit();
                }
            }
        }
    }


    public function register()
{
    $conectar = parent::Conexion();
    parent::set_names();

    if (isset($_POST["enviar"]) && $_POST["enviar"] == "si") {

        $nombres   = trim($_POST["nombres"]);
        $apellidos = trim($_POST["apellidos"]);
        $correo    = trim($_POST["correo"]);
        $clave     = trim($_POST["clave"]);
        $usuario   = trim($_POST["usuario"]);
        $cedula    = trim($_POST["cedula"]);
        $id_rol    = isset($_POST['rol']) ? intval($_POST['rol']) : 0;

        // Validar campos vacíos y rol seleccionado
        if (
            empty($correo) || empty($clave) || empty($nombres) ||
            empty($apellidos) || empty($usuario) || empty($cedula) ||
            $id_rol <= 0
        ) {
            header("Location: " . Conectar::ruta() . "registrar.php?m=2");
            exit();
        }

        // Verificar si el correo ya existe
        $sql = "SELECT * FROM usuario WHERE correo = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $correo);
        $stmt->execute();
        $usuarioExistente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuarioExistente) {
            header("Location: " . Conectar::ruta() . "registrar.php?m=1");
            exit();
        }

        // Insertar usuario
        $hashPassword = password_hash($clave, PASSWORD_DEFAULT);

        $insertSql = "INSERT INTO usuario 
            (nombres, apellidos, correo, clave, id_rol, fecha_creacion, estado, imagen, usuario, cedula)
            VALUES (?, ?, ?, ?, ?, NOW(), 1, 'user-dummy-img.jpg', ?, ?)";

        $insertStmt = $conectar->prepare($insertSql);
        $insertStmt->execute([
            $nombres,
            $apellidos,
            $correo,
            $hashPassword,
            $id_rol,
            $usuario,
            $cedula
        ]);

        // Crear sesión automáticamente
        $id_usuario = $conectar->lastInsertId();

        $_SESSION["id_usuario"] = $id_usuario;
        $_SESSION["nombres"]    = $nombres;
        $_SESSION["apellidos"]  = $apellidos;
        $_SESSION["id_rol"]     = $id_rol;
        $_SESSION["correo"]     = $correo;
        $_SESSION["usu_img"]    = 'user-dummy-img.jpg';
        $_SESSION["usuario"]    = $usuario;
        $_SESSION["cedula"]     = $cedula;

        header("Location: " . Conectar::ruta() . "views/home");
        exit();
    }
}



}
