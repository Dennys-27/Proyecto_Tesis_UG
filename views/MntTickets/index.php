<?php
require_once("../../config/conexion.php");
require_once("../../models/Ticket.php");

$ticket = new Ticket();

// Validar acceso del usuario a la sección tickets
$datos = $ticket->validar_acceso($_SESSION["id_usuario"], "tickets");

if ($datos["acceso"] == 1) {
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tickets | Sistema de Gestión</title>

    <?php include '../html/head.php'; ?>

    <style>
         /* Botón general */
        #btnnuevo {
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }
        #btnnuevo svg {
            width: 20px;
            height: 20px;
        }
        .badge-activo {
            background: #28a745;
            color: white;
            padding: 5px 10px;
            border-radius: 10px;
        }

        .badge-cerrado {
            background: #dc3545;
            color: white;
            padding: 5px 10px;
            border-radius: 10px;
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

        <?php include '../html/sidebard.php'; ?>
        <div id="overlay"></div>

        <div class="main-area">
            <?php include '../html/header.php'; ?>

            <main class="content">
                <div class="page-header">
                    <h1>Gestión de Tickets</h1>
                    <p class="muted">Administra los tickets registrados por los usuarios.</p>
                </div>

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="card-header">
                                <button type="button" id="btnnuevo" class="btn btn-primary rounded-pill">
                                    <svg viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
                                    Nuevo Ticket
                                </button>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="table_data" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Título</th>
                                                    <th>Categoría</th>
                                                    <th>Usuario</th>
                                                    <th>Fecha</th>
                                                    <th>Estado</th>
                                                    <th>Ver</th>
                                                    <th>Editar</th>
                                                    <th>Eliminar</th>
                                                    <th>Responder</th>
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

            <footer class="footer">
                <div>Universidad de Guayaquil — Ingeniería de Software</div>
                <div class="small muted"><span id="yearFooter"></span></div>
            </footer>

            <?php require_once("mantenimiento.php"); ?>

                            <script src="../../assets/js/dashboard/create-proyecto.js"></script>
                <script src="../../assets/js/alertas.js"></script>
            <script type="text/javascript" src="mtntickets.js"></script>

        </div>
    </div>
</body>

</html>

<?php
} else {
    header("Location:" . Conectar::ruta() . "views/404/");
    exit();
}
?>
