<?php
require_once("../config/conexion.php");
require_once("../models/Galeria.php");

$galeria = new Galeria();

switch ($_GET["op"]) {

    case 'listar':
        $datos = $galeria->listar_archivos();
        echo json_encode($datos);
        break;

    case 'subir':
        if (!empty($_FILES['archivo']['name'])) {

        // CREAR CARPETA SI NO EXISTE
        $carpeta = "../uploads/";

        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        // OBTENER NOMBRE ORIGINAL
        $nombre = $_FILES['archivo']['name'];

        // RUTA FINAL
        $ruta = $carpeta . $nombre;

        // MOVER ARCHIVO
        move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta);

        // DETECTAR TIPO (imagen/pdf/doc/xls/mp4/etc)
        $tipo = mime_content_type($ruta);

        // GUARDAR EN LA BD
        $galeria->insertar_archivo($_SESSION["id_usuario"], $nombre, $ruta, $tipo);

        echo "ok";
    }
    break;

    case 'eliminar':
        $galeria->eliminar_archivo($_POST["id_galeria"]);
        echo "ok";
        break;
}
?>
