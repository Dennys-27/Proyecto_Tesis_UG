<?php 
class Menu extends Conectar
{
    public function getMenuByRol($id_rol)
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT m.nombre, m.icono, m.link, m.badge
                FROM menu m
                INNER JOIN menu_roles mr ON m.id_menu = mr.id_menu
                WHERE mr.id_rol = :rol AND m.estado = 1
                ORDER BY m.id_menu";

        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(":rol", $id_rol, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
