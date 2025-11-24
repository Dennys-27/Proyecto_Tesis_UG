<?php
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/PasswordReset.php';

class AuthController
{
    private $user;
    private $passwordReset;

    public function __construct()
    {
        $this->user = new Usuario();
        $this->passwordReset = new PasswordReset();
    }

    // Solicitar reset
    public function solicitarReset()
    {
        $email = $_POST["email"] ?? null;

        if (!$email) {
            echo json_encode(["error" => "Correo requerido"]);
            return;
        }

        $usuario = $this->user->verificarUsuario($email);

        if (!$usuario) {
            echo json_encode(["error" => "El correo no existe"]);
            return;
        }

        $token = bin2hex(random_bytes(16));
        $this->passwordReset->crearToken($usuario["id"], $token);

        echo json_encode([
            "success" => true,
            "token" => $token
        ]);
    }

    // Confirmar reset
    public function confirmarReset()
    {
        $token = $_POST["token"] ?? null;
        $password = $_POST["password"] ?? null;

        if (!$token || !$password) {
            echo json_encode(["error" => "Datos incompletos"]);
            return;
        }

        $registro = $this->passwordReset->obtenerRegistro($token);

        if (!$registro) {
            echo json_encode(["error" => "Token inválido"]);
            return;
        }

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $this->user->actualizarPassword($registro["user_id"], $password_hash);
        $this->passwordReset->eliminarToken($token);

        echo json_encode(["success" => true]);
    }
}
