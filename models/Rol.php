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

    /* TODO: Listar Registro por ID en especifico */
        public function get_rol_x_rol_id($rol_id){
            $conectar=parent::Conexion();
            $sql="SP_L_ROL_02 ?";
            $query=$conectar->prepare($sql);
            $query->bindValue(1,$rol_id);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        /* TODO: Eliminar o cambiar estado a eliminado */
        public function delete_rol($rol_id){
            $conectar=parent::Conexion();
            $sql="SP_D_ROL_01 ?";
            $query=$conectar->prepare($sql);
            $query->bindValue(1,$rol_id);
            $query->execute();
        }

        /* TODO: Registro de datos */
        public function insert_rol($suc_id,$rol_nom){
            $conectar=parent::Conexion();
            $sql="SP_I_ROL_01 ?,?";
            $query=$conectar->prepare($sql);
            $query->bindValue(1,$suc_id);
            $query->bindValue(2,$rol_nom);
            $query->execute();
        }

        /* TODO:Actualizar Datos */
        public function update_rol($rol_id,$suc_id,$rol_nom){
            $conectar=parent::Conexion();
            $sql="SP_U_ROL_01 ?,?,?";
            $query=$conectar->prepare($sql);
            $query->bindValue(1,$rol_id);
            $query->bindValue(2,$suc_id);
            $query->bindValue(3,$rol_nom);
            $query->execute();
        }
}
