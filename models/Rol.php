<?php
class Rol extends Conectar
{

    public function validar_acceso_rol($id_usuario, $menu_ident)
    {
        $conectar = parent::Conexion();
        $sql = "CALL SP_L_MENU_03(?, ?)";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $id_usuario, PDO::PARAM_INT);
        $query->bindValue(2, $menu_ident, PDO::PARAM_STR);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function get_rol()
    {
        $conectar = parent::Conexion();
        $sql = "select * from rol";
        $query = $conectar->prepare($sql);

        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
