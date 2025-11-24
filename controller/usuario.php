<?php
require_once("../config/conexion.php");
require_once("../models/Usuario.php");

$usuario = new Usuario();

$op = isset($_GET['op']) ? $_GET['op'] : '';

switch($op){

    case 'listar':
        $datos = $usuario->getUsuarios();
        $data = [];
        foreach($datos as $row){
            $sub_array = [];
            if ($row["imagen"] != ''){
                    $sub_array[] =
                    "<div class='d-flex align-items-center'>" .
                        "<div class='flex-shrink-0 me-2'>".
                            "<img src='../../uploads/".$row["imagen"]."' alt='' class='avatar-xs rounded-circle'>".
                        "</div>".
                    "</div>";
                }else{
                    $sub_array[] =
                    "<div class='d-flex align-items-center'>" .
                        "<div class='flex-shrink-0 me-2'>".
                            "<img src='../../uploads/no_imagen.png' alt='' class='avatar-xs rounded-circle'>".
                        "</div>".
                    "</div>";
                }
            $sub_array[] = $row["nombres"];
            $sub_array[] = $row["apellidos"];
            $sub_array[] = $row["correo"];
            $sub_array[] = $row["nombre"];
            $sub_array[] = $row["cedula"];
            $sub_array[] = $row["usuario"];
            $sub_array[] = $row["fecha_creacion"];

            $sub_array[] = $row["estado"] == 1
                ? '<span class="badge-estado activo">Activo</span>'
                : '<span class="badge-estado inactivo">Inactivo</span>';

            // Botones
            $sub_array[] = '
                <button type="button" onClick="permisos(' . $row["id_usuario"] . ')" class="btn-icon btn-primary">
                    <svg viewBox="0 0 24 24"><path d="M5 20h14v-2H5v2zm7-18l-5 5h3v4h4V7h3l-5-5z"/></svg>
                </button>';

            $sub_array[] = '
                <button type="button" onClick="editar(' . $row["id_usuario"] . ')" class="btn-icon btn-warning">
                    <svg viewBox="0 0 24 24"><path d="M3 17.25V21h3.75l11-11.03-3.75-3.75L3 17.25zM20.71 7.04a1.003 1.003 0 0 0 0-1.42l-2.34-2.34a1.003 1.003 0 0 0-1.42 0l-1.83 1.83 3.75 3.75 1.84-1.82z"/></svg>
                </button>';

            $sub_array[] = '
                <button type="button" onClick="eliminar(' . $row["id_usuario"] . ')" class="btn-icon btn-danger">
                    <svg viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                </button>';

            $sub_array[] = '
                <button type="button" onClick="activar(' . $row["id_usuario"] . ')" class="btn-icon btn-primary">
                    <svg viewBox="0 0 24 24" width="20" height="20">
                        <path d="M7 12l5 5 5-5H7z" fill="currentColor"/>
                    </svg>
                </button>';
                $data[] = $sub_array;
        }
        echo json_encode(["data"=>$data]);
    break;

    case "guardaryeditar":
            if(empty($_POST["id_rol"])){
                $rol->insert_rol($_POST["nombre"]);
            }else{
                $rol->update_rol($_POST["id_rol"],$_POST["nombre"]);
            }
    break;

    case "mostrar":
            $datos=$rol->get_rol_x_rol_id($_POST["rol_id"]);
            if (is_array($datos)==true and count($datos)>0){
                foreach($datos as $row){
                    $output["id_rol"] = $row["id_rol"];
                    $output["nombre"] = $row["nombre"];
                }
                echo json_encode($output);
            }
    break;

    case 'eliminar':
        $id = $_POST['id_usuario'];
        $usuario->eliminarUsuario($id);
        echo json_encode(["status"=>"success"]);
    break;

    case 'cambiar_estado':
        $id = $_POST['id_usuario'];
        $estado = $_POST['estado'];
        $usuario->cambiarEstado($id, $estado);
        echo json_encode(["status"=>"success"]);
    break;

}
?>
