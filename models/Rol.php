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

    public function get_rol_combo()
    {
        $conectar = parent::Conexion();
        $sql = "select id_rol, nombre from rol where estado = 1";
        $query = $conectar->prepare($sql);

        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /* TODO: Listar Registro por ID en especifico */
public function get_rol_x_rol_id($rol_id){
    $conectar = parent::Conexion();
    $sql = "CALL SP_L_ROL_02(?)";
    $query = $conectar->prepare($sql);
    $query->bindValue(1, $rol_id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

/* TODO: Eliminar o cambiar estado a eliminado */
public function eliminar_rol($rol_id){
    $conectar = parent::Conexion();
    $sql = "update rol set estado = 0 where id_rol = ?";
    $query = $conectar->prepare($sql);
    $query->bindValue(1, $rol_id, PDO::PARAM_INT);
    $query->execute();
}

public function activar_rol($rol_id){
    $conectar = parent::Conexion();
    $sql = "update rol set estado = 1 where id_rol = ?";
    $query = $conectar->prepare($sql);
    $query->bindValue(1, $rol_id, PDO::PARAM_INT);
    $query->execute();
}

/* INSERTAR ROL */
public function insert_rol($rol_nom){
    $conectar = parent::Conexion();
    $sql = "INSERT INTO rol (nombre) VALUES (?)";
    $query = $conectar->prepare($sql);
    $query->bindValue(1, $rol_nom, PDO::PARAM_STR);
    $query->execute();
}


/* ACTUALIZAR ROL */
public function update_rol($rol_id,  $rol_nom){
    $conectar = parent::Conexion();
    $sql = "UPDATE rol SET nombre = ? WHERE id_rol = ?";
    $query = $conectar->prepare($sql);
    $query->bindValue(1, $rol_nom, PDO::PARAM_STR);
    $query->bindValue(2, $rol_id, PDO::PARAM_INT);
    $query->execute();
}

}
