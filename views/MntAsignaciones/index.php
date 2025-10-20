<?php
require_once("../../config/conexion.php");
require_once("../../models/Rol.php");


$rol = new Rol();

// Validar acceso al dashboard
$datos = $rol->validar_acceso_rol($_SESSION["id_usuario"], "asignaciones");

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
                    <!-- Header -->
                    <div
                        class="page-header d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h1 class="mb-1">Mis Tareas</h1>
                            <p class="muted mb-0">
                                Resumen de tus actividades y entregas pendientes.
                            </p>
                        </div>
                    </div>

                    <!-- Filtros -->
                    <section class="filters mt-4">
                        <div class="filters-box">
                            <div class="filter-group">
                                <input
                                    type="text"
                                    id="searchInput"
                                    class="form-control"
                                    placeholder="🔎 Buscar actividad..." />
                            </div>

                            <div class="filter-group">
                                <label for="dateFrom">Desde</label>
                                <input type="date" id="dateFrom" class="form-control" />
                            </div>

                            <div class="filter-group">
                                <label for="dateTo">Hasta</label>
                                <input type="date" id="dateTo" class="form-control" />
                            </div>

                            <div class="filter-group">
                                <label for="sortFilter">Ordenar</label>
                                <select id="sortFilter" class="form-control">
                                    <option value="recent">Más recientes</option>
                                    <option value="oldest">Más antiguas</option>
                                </select>
                            </div>

                            <div class="filter-group">
                                <button class="btn btn-primary w-100" id="applyFilters">
                                    Aplicar
                                </button>
                            </div>
                        </div>
                    </section>

                    <!-- Últimas Actividades -->
                    <section class="latest-activities mt-4">
                        <h2 class="mb-3">Actividades De Proyecto</h2>
                        <div class="activities-list" id="activitiesList">
                            <!-- Actividades dinámicas -->
                        </div>

                        <!-- Paginación -->
                        <div class="pagination mt-3 d-flex justify-content-center gap-2">
                            <button class="btn btn-sm btn-secondary" id="prevPage">
                                Anterior
                            </button>
                            <span id="pageInfo"></span>
                            <button class="btn btn-sm btn-secondary" id="nextPage">
                                Siguiente
                            </button>
                        </div>
                    </section>
                </main>


                <!-- Modal de Actividad -->
                <div
                    class="modal fade"
                    id="actividadModal"
                    tabindex="-1"
                    aria-labelledby="actividadModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content modal-dark position-relative">
                            <!-- Fondo visual -->
                            <div class="modal-bg-image"></div>

                            <!-- HEADER -->
                            <div class="modal-header border-0">
                                <h5 class="modal-title text-white" id="actividadModalLabel">
                                    Detalle de Actividad
                                </h5>
                                <button
                                    type="button"
                                    class="btn-close btn-close-white"
                                    data-bs-dismiss="modal"
                                    aria-label="Cerrar"></button>
                            </div>

                            <!-- BODY -->
                            <div class="modal-body position-relative" style="z-index: 10">
                                <p class="text-white">
                                    <strong>Proyecto:</strong> <span id="modalProyecto"></span>
                                </p>
                                <p class="text-white">
                                    <strong>Tarea:</strong> <span id="modalTarea"></span>
                                </p>
                                <p class="text-white">
                                    <strong>Tiempo estimado:</strong>
                                    <span id="modalTiempo"></span>
                                </p>
                                <p class="text-white">
                                    <strong>Fecha asignada:</strong> <span id="modalFecha"></span>
                                </p>

                                <!-- Input de entrega -->
                                <div class="mt-3">
                                    <label for="fileEntrega" class="form-label text-white">Subir entrega</label>
                                    <input
                                        type="file"
                                        class="form-control form-dark"
                                        id="fileEntrega"
                                        accept=".pdf,.docx,.pptx,.zip,.rar,.jpg,.png" />
                                </div>
                            </div>

                            <!-- FOOTER -->
                            <div
                                class="modal-footer border-0 position-relative"
                                style="z-index: 10">
                                <button
                                    type="button"
                                    id="btnPrevActividad"
                                    class="btn btn-secondary">
                                    ← Anterior
                                </button>
                                <button
                                    type="button"
                                    id="btnNextActividad"
                                    class="btn btn-accent">
                                    Siguiente →
                                </button>
                                <button
                                    type="button"
                                    id="btnEntregarActividad"
                                    class="btn btn-success">
                                    Entregar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FOOTER -->
                <footer class="footer">
                    <div>Universidad de Guayaquil — Ingeniería de Software</div>
                    <div class="small muted">Diseñado por tu equipo • <span id="yearFooter"></span></div>
                </footer>


                <script src="../assets/js/dashboard/create-proyecto.js"></script>
                <script src="../assets/js/alertas.js"></script>
                <!-- Quill -->
                <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet" />
                <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

                <script src="../../assets/js/estudiante/subir_asignacion.js"></script>

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