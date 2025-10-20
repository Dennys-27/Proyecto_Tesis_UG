<?php
    require_once("../../config/conexion.php");


    header("Location:".Conectar::ruta()."?c=".$_SESSION["id_usuario"]);

    session_destroy();
    exit();
?>