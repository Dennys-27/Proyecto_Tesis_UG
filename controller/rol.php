<?php

/*  TODO: LLAMANDO CLASES */
require_once("../config/conexion.php");

require_once("../models/Rol.php");
/* TODO: INICIALIZANDO CLASES */
// Creando una nueva instancia (objeto) de la clase Rol. 
$rol = new Rol();


switch ($_GET["op"]) {

    case "listar":
        $datos = $rol->get_rol();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();

            $sub_array[] = $row["nombre"];
            $sub_array[] = $row["descripcion"];
            $sub_array[] = $row["usuario_creacion"];
            $sub_array[] = $row["fecha_creacion"];
            $sub_array[] = $row["estado"] == 1
                ? '<span class="badge-estado activo">Activo</span>'
                : '<span class="badge-estado inactivo">Inactivo</span>';

            $sub_array[] = '<button type="button" onClick="permisos(' . $row["id_rol"] . ')" class="btn-icon btn-primary">
<svg viewBox="0 0 24 24"><path d="M5 20h14v-2H5v2zm7-18l-5 5h3v4h4V7h3l-5-5z"/></svg>
</button>';

            $sub_array[] = '<button type="button" onClick="editar(' . $row["id_rol"] . ')" class="btn-icon btn-warning">
<svg viewBox="0 0 24 24"><path d="M3 17.25V21h3.75l11-11.03-3.75-3.75L3 17.25zM20.71 7.04a1.003 1.003 0 0 0 0-1.42l-2.34-2.34a1.003 1.003 0 0 0-1.42 0l-1.83 1.83 3.75 3.75 1.84-1.82z"/></svg>
</button>';

            $sub_array[] = '<button type="button" onClick="eliminar(' . $row["id_rol"] . ')" class="btn-icon btn-danger">
<svg viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
</button>';


            $data[] = $sub_array;
        }
        // necesitamos este codigo paracontar cuantos informacion hay

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecorsd" => count($data),
            "aaData" => $data
        );
        echo json_encode($results);
        break;
}
