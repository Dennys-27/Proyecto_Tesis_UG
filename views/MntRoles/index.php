<?php
require_once("../../config/conexion.php");
require_once("../../models/Rol.php");


$rol = new Rol();

// Validar acceso al dashboard
$datos = $rol->validar_acceso_rol($_SESSION["id_usuario"], "tickets");

if ($datos["acceso"] == 1) {

?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Tickets - Sistema de Gestión</title>

        <?php include '../html/head.php'; ?>
        <style>
            /* Botón con icono a la izquierda */
            #btnnuevo {
                padding: 0.5rem 1rem;
                display: flex;
                align-items: center;
                justify-content: flex-start;
                /* Icono y texto a la izquierda */
                gap: 0.5rem;
                /* Espacio entre icono y texto */
                margin-bottom: 1rem;
            }

            #btnnuevo .btn-icon {
                width: 20px;
                height: 20px;
                flex-shrink: 0;
            }

            /* Badges para estado */
            .badge-estado {
                display: inline-block;
                padding: 0.35em 0.75em;
                font-size: 0.85em;
                font-weight: 600;
                border-radius: 0.5rem;
                color: #fff;
                text-align: center;
            }

            .badge-estado.activo {
                background-color: #28a745;
            }

            .badge-estado.inactivo {
                background-color: #dc3545;
            }

            /* Botones con iconos SVG */
            .btn-icon svg {
                width: 18px;
                height: 18px;
                vertical-align: middle;
                fill: currentColor;
            }

            .btn-icon {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 6px 10px;
                border-radius: 0.5rem;
                border: none;
                cursor: pointer;
                transition: all 0.2s ease-in-out;
            }

            .btn-icon:hover {
                opacity: 0.85;
            }

            .btn-primary {
                background-color: #007bff;
                color: #fff;
            }

            .btn-warning {
                background-color: #ffc107;
                color: #212529;
            }

            .btn-danger {
                background-color: #dc3545;
                color: #fff;
            }

            /* Tabla responsive */
            .table-responsive {
                overflow-x: auto;
            }
        </style>
    </head>

    <body>
        <div class="app-shell">
            <!-- SIDEBAR -->
            <?php include '../html/sidebard.php'; ?>

            <!-- OVERLAY PARA MÓVIL -->
            <div id="overlay"></div>

            <!-- MAIN AREA -->
            <div class="main-area">
                <!-- NAVBAR / TOPBAR -->
                <?php include '../html/header.php'; ?>

                <!-- PAGE CONTENT -->
                <main class="content">
                    <div class="page-header">
                        <h1>Tablero</h1>
                        <p class="muted">
                            Bienvenido al sistema de gestión — aquí tienes un resumen rápido.
                        </p>
                    </div>

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Botón Nuevo Registro -->
                                <div class="card-header">
                                    <button type="button" id="btnnuevo" class="btn btn-primary rounded-pill d-flex align-items-center justify-content-start">
                                        <!-- Icono SVG -->
                                        <svg class="btn-icon me-2" viewBox="0 0 24 24" width="20" height="20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                        </svg>
                                        Nuevo Registro
                                    </button>
                                </div>

                                <div class="card">


                                    <!-- Tabla responsive -->
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="table_data" class="table table-bordered table-striped align-middle">
                                                <thead>
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th>Descripcion</th>
                                                        <th>Usuario Creacion</th>
                                                        <th>Fecha Creacion</th>
                                                        <th>Estado</th>
                                                        <th>Permisos</th>
                                                        <th>Editar</th>
                                                        <th>Eliminar</th>
                                                        <th>Activar</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>


                <!-- FOOTER -->
                <footer class="footer">
                    <div>Universidad de Guayaquil — Ingeniería de Software</div>
                    <div class="small muted">Diseñado por tu equipo • <span id="yearFooter"></span></div>
                </footer>

                <?php require_once("mantenimiento.php"); ?>
                <script src="../../assets/js/dashboard/create-proyecto.js"></script>
                <script src="../../assets/js/alertas.js"></script>
                <!-- Quill -->
                <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet" />
                <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

                <script type="text/javascript" src="mntroles.js"></script>
            </div>
        </div>
    </body>

    </html>

<?php
} else {
    // Redirigir si no tiene acceso
    header("Location:" . Conectar::ruta() . "views/404/");
    exit();
}
?>