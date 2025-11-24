<?php
require_once __DIR__ . '/../config/conexion.php';

class Usuario extends Conectar
{
    private $db;

    public function __construct()
    {
        $this->db = parent::Conexion();
        $this->set_names();
    }

    public function verificarUsuario($email)
    {
        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarPassword($user_id, $password)
    {
        $sql = "UPDATE usuarios SET password = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$password, $user_id]);
    }

    public function getUsuarios() {
        $con = parent::Conexion();
        $sql = "SELECT 
u.id_usuario,
u.nombres, 
u.apellidos,
u.correo,
u.cedula,
u.imagen,
r.nombre,
u.usuario,
u.fecha_creacion,
u.estado
                FROM usuario u
                INNER JOIN rol r ON u.id_rol = r.id_rol
                ORDER BY u.id_usuario DESC";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un usuario por ID
    public function getUsuario($id_usuario) {
        $con = parent::Conexion();
        $sql = "SELECT * FROM tb_usuarios WHERE id_usuario = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute([$id_usuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Registrar nuevo usuario
    public function registrarUsuario($data) {
        $con = parent::Conexion();
        $sql = "INSERT INTO tb_usuarios(nombre, apellido, correo, password, id_rol, cedula, imagen)
                VALUES(?, ?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        return $stmt->execute([
            $data['nombre'],
            $data['apellido'],
            $data['correo'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['id_rol'],
            $data['cedula'],
            $data['imagen']
        ]);
    }

    // Actualizar usuario
    public function actualizarUsuario($id_usuario, $data) {
        $con = parent::Conexion();
        $sql = "UPDATE tb_usuarios SET nombre=?, apellido=?, correo=?, id_rol=?, cedula=? WHERE id_usuario=?";
        $stmt = $con->prepare($sql);
        return $stmt->execute([
            $data['nombre'],
            $data['apellido'],
            $data['correo'],
            $data['id_rol'],
            $data['cedula'],
            $id_usuario
        ]);
    }

    // Eliminar usuario
    public function eliminarUsuario($id_usuario) {
        $con = parent::Conexion();
        $sql = "DELETE FROM tb_usuarios WHERE id_usuario=?";
        $stmt = $con->prepare($sql);
        return $stmt->execute([$id_usuario]);
    }

    // Activar / Desactivar usuario
    public function cambiarEstado($id_usuario, $estado) {
        $con = parent::Conexion();
        $sql = "UPDATE tb_usuarios SET estado=? WHERE id_usuario=?";
        $stmt = $con->prepare($sql);
        return $stmt->execute([$estado, $id_usuario]);
    }
}
