<?php
class Ticket extends Conectar {

    // Validar acceso (puedes adaptar la lógica a tu RBAC)
    public function validar_acceso($usuario_id, $seccion){
        $conectar = parent::Conexion();
        // Ejemplo simple: devolver acceso = 1 siempre. Ajusta según tu lógica real.
        // Si tienes tabla de permisos, consulta aquí.
        return array("acceso" => 1);
    }

    // Listar todos (para DataTables simple)
    public function get_tickets(){
        $conectar = parent::Conexion();
        $sql = "SELECT t.ticket_id, t.titulo, t.categoria, t.descripcion, t.usuario_id, t.fecha_creacion, t.estado, u.nombres as usuario_nombre
                FROM ticket t
                LEFT JOIN usuario u ON u.id_usuario = t.usuario_id
                WHERE t.estado IN (0,1)
                ORDER BY t.ticket_id DESC";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener por ID
    public function get_ticket_by_id($ticket_id){
        $conectar = parent::Conexion();
        $sql = "SELECT ticket_id, titulo, categoria, descripcion, usuario_id, fecha_creacion, estado
                FROM ticket
                WHERE ticket_id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $ticket_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Insertar
    public function insert_ticket($titulo, $categoria, $descripcion, $usuario_id){
        $conectar = parent::Conexion();
        $sql = "INSERT INTO ticket (titulo, categoria, descripcion, usuario_id) VALUES (?, ?, ?, ?)";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $titulo, PDO::PARAM_STR);
        $stmt->bindValue(2, $categoria, PDO::PARAM_STR);
        $stmt->bindValue(3, $descripcion, PDO::PARAM_STR);
        $stmt->bindValue(4, $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        return $conectar->lastInsertId();
    }

    // Actualizar
    public function update_ticket($ticket_id, $titulo, $categoria, $descripcion){
        $conectar = parent::Conexion();
        $sql = "UPDATE ticket SET titulo = ?, categoria = ?, descripcion = ? WHERE ticket_id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $titulo, PDO::PARAM_STR);
        $stmt->bindValue(2, $categoria, PDO::PARAM_STR);
        $stmt->bindValue(3, $descripcion, PDO::PARAM_STR);
        $stmt->bindValue(4, $ticket_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Eliminación lógica (marcar estado = 0)
    public function delete_ticket($ticket_id){
        $conectar = parent::Conexion();
        $sql = "UPDATE ticket SET estado = 0 WHERE ticket_id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $ticket_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Opcional: cambiar estado (abrir/cerrar)
    public function set_estado($ticket_id, $estado){
        $conectar = parent::Conexion();
        $sql = "UPDATE ticket SET estado = ? WHERE ticket_id = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $estado, PDO::PARAM_INT);
        $stmt->bindValue(2, $ticket_id, PDO::PARAM_INT);
        $stmt->execute();
    }



    public function get_conversacion($ticket_id){
        $conectar = parent::conexion();
        $sql = "SELECT tm.*, u.nombres as remitente_nombre
                FROM tb_ticket_mensajes tm
                INNER JOIN usuario u ON tm.remitente_id = u.id_usuario
                WHERE tm.ticket_id = ?
                ORDER BY tm.fecha_envio ASC";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $ticket_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Guardar mensaje nuevo
    public function enviar_mensaje($ticket_id, $remitente_id, $mensaje){
        $conectar = parent::conexion();
        $sql = "INSERT INTO tb_ticket_mensajes (ticket_id, remitente_id, mensaje)
                VALUES (?, ?, ?)";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $ticket_id);
        $query->bindValue(2, $remitente_id);
        $query->bindValue(3, $mensaje);
        $query->execute();
    }

    
}
?>
