<?php


class Galeria extends Conectar {

    // Validar acceso (puedes adaptar la lógica a tu RBAC)
    public function validar_acceso($usuario_id, $seccion){
        $conectar = parent::Conexion();
        // Ejemplo simple: devolver acceso = 1 siempre. Ajusta según tu lógica real.
        // Si tienes tabla de permisos, consulta aquí.
        return array("acceso" => 1);
    }
    public function listar_archivos() {
        $con = parent::Conexion();
        parent::set_names();

        $sql = "SELECT * FROM tb_galeria WHERE estado = 1 ORDER BY fecha_creacion DESC";
        $query = $con->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertar_archivo($id_usuario, $nombre, $ruta, $tipo) {
        $con = parent::Conexion();
        parent::set_names();

        $sql = "INSERT INTO tb_galeria (id_usuario, nombre_archivo, ruta_archivo, tipo) VALUES (?,?,?,?)";
        $query = $con->prepare($sql);
        $query->bindValue(1, $id_usuario);
        $query->bindValue(2, $nombre);
        $query->bindValue(3, $ruta);
        $query->bindValue(4, $tipo);
        $query->execute();
    }

    public function eliminar_archivo($id_galeria) {
        $con = parent::Conexion();
        parent::set_names();

        $sql = "UPDATE tb_galeria SET estado = 0 WHERE id_galeria = ?";
        $query = $con->prepare($sql);
        $query->bindValue(1, $id_galeria);
        $query->execute();
    }
}
?>
