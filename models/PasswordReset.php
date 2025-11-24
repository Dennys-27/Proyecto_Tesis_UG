<?php

require_once __DIR__ . '/../config/conexion.php';

class PasswordReset extends Conectar {

    private $db;

    public function __construct() {
        $this->db = parent::Conexion();
        $this->set_names();
    }

    public function crearToken($email, $token) {
        $sql = "INSERT INTO password_resets (email, token, fecha) VALUES (?, ?, NOW())";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$email, $token]);
    }

    public function obtenerPorToken($token) {
        $sql = "SELECT * FROM password_resets WHERE token = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function eliminarToken($email) {
        $sql = "DELETE FROM password_resets WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$email]);
    }
}
