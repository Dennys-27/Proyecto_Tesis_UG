<?php
require_once("../config/conexion.php");
require_once("../models/Ticket.php");


$ticket = new Ticket();

switch($_GET["op"]){

    case "listar":
        $datos = $ticket->get_tickets();
        $data = array();

        foreach($datos as $row){
            $sub_array = array();
            $sub_array[] = $row["titulo"];
            $sub_array[] = $row["categoria"];
            $sub_array[] = isset($row["usuario_nombre"]) ? $row["usuario_nombre"] : $row["usuario_id"];
            $sub_array[] = $row["fecha_creacion"];
            $sub_array[] = $row["estado"] == 1 ? '<span class="badge-activo">Abierto</span>' : '<span class="badge-cerrado">Cerrado</span>';

            $sub_array[] = '<button type="button" onClick="ver('.$row["ticket_id"].')" class="btn-icon btn-primary" title="Ver">
                                <svg viewBox="0 0 24 24"><path d="M12 5c-7 0-11 7-11 7s4 7 11 7 11-7 11-7-4-7-11-7z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>';

            $sub_array[] = '<button type="button" onClick="editar('.$row["ticket_id"].')" class="btn-icon btn-warning" title="Editar">
                                <svg viewBox="0 0 24 24"><path d="M3 17.25V21h3.75l11-11.03-3.75-3.75L3 17.25zM20.71 7.04a1.003 1.003 0 0 0 0-1.42l-2.34-2.34a1.003 1.003 0 0 0-1.42 0l-1.83 1.83 3.75 3.75 1.84-1.82z"/></svg>
                            </button>';

            $sub_array[] = '<button type="button" onClick="eliminar('.$row["ticket_id"].')" class="btn-icon btn-danger" title="Eliminar">
                                <svg viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                            </button>';
            
            $sub_array[] = '<button type="button" onClick="responder('.$row["ticket_id"].')" class="btn-icon btn-info" title="Responder">
                        <svg viewBox="0 0 24 24">
                            <path d="M21 11.5l-8.5-6v4c-6 0-10 2-12 6 3-2 6-3 12-3v4l8.5-5z"/>
                        </svg>
                    </button>';

            $data[] = $sub_array;
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );

        echo json_encode($results);
    break;

    case "mostrar":
        $ticket_id = isset($_POST["ticket_id"]) ? $_POST["ticket_id"] : 0;
        $datos = $ticket->get_ticket_by_id($ticket_id);
        echo json_encode($datos);
    break;

    case "guardaryeditar":
        // datos del formulario
        $ticket_id = isset($_POST["ticket_id"]) && $_POST["ticket_id"] !== "" ? intval($_POST["ticket_id"]) : null;
        $titulo = isset($_POST["titulo"]) ? trim($_POST["titulo"]) : "";
        $categoria = isset($_POST["categoria"]) ? trim($_POST["categoria"]) : "";
        $descripcion = isset($_POST["descripcion"]) ? trim($_POST["descripcion"]) : "";
        $usuario_id = isset($_SESSION["id_usuario"]) ? intval($_SESSION["id_usuario"]) : 1; // fallback 1

        if($ticket_id === null){
            // insertar
            $newId = $ticket->insert_ticket($titulo, $categoria, $descripcion, $usuario_id);
            echo json_encode(array("status"=>"ok","ticket_id"=>$newId));
        } else {
            // actualizar
            $ticket->update_ticket($ticket_id, $titulo, $categoria, $descripcion);
            echo json_encode(array("status"=>"ok","ticket_id"=>$ticket_id));
        }
    break;

    case "eliminar":
        $ticket_id = isset($_POST["ticket_id"]) ? intval($_POST["ticket_id"]) : 0;
        $ticket->delete_ticket($ticket_id);
        echo json_encode("ok");
    break;

    case "set_estado":
        $ticket_id = isset($_POST["ticket_id"]) ? intval($_POST["ticket_id"]) : 0;
        $estado = isset($_POST["estado"]) ? intval($_POST["estado"]) : 1;
        $ticket->set_estado($ticket_id, $estado);
        echo json_encode("ok");
    break;
    
    case "listar_conversacion":
        $datos = $ticket->get_conversacion($_POST["ticket_id"]);
        echo json_encode($datos);
    break;

    // Enviar mensaje
    case "enviar":

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $ticket_id = $_POST["ticket_id"];
        $mensaje = $_POST["mensaje"];

        // EL CORRECTO → id_usuario
        $usuario_id = $_SESSION["id_usuario"];

        if (empty($usuario_id)) {
            echo json_encode(["error" => "No existe id_usuario en la sesión"]);
            exit();
        }

        $ticket->enviar_mensaje($ticket_id, $usuario_id, $mensaje);

        echo json_encode(["status" => "ok"]);
    break;




    // Obtener info del ticket
    case "info":
        $datos = $ticket->get_ticket($_POST["ticket_id"]);
        echo json_encode($datos);
    break;


    default:
        echo json_encode(array("error" => "Operación inválida"));
    break;
}
