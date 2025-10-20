<?php
require_once("../../config/conexion.php");
require_once("../../models/Rol.php");


$rol = new Rol();

// Validar acceso al dashboard
$datos = $rol->validar_acceso_rol($_SESSION["id_usuario"], "tareas");

if ($datos["acceso"] == 1) {
$rol_usuario = $_SESSION['id_rol'];
?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Roles - Sistema de Gestión</title>

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
                <!-- PAGE CONTENT -->
                <?php if ($rol_usuario == 2): ?>
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

                        <!-- Cards resumen -->

                        <div class="grid">
                            <div class="card small">
                                <div class="card-icon professor">
                                    <svg
                                        viewBox="0 0 24 24"
                                        fill="currentColor"
                                        width="32"
                                        height="32">
                                        <path
                                            d="M9 11H7v2h2v-2zm0 4H7v2h2v-2zm4-4h-2v2h2v-2zm0 4h-2v2h2v-2zm4-8h-8v2h8V7zm0 4h-8v2h8v-2z" />
                                    </svg>
                                </div>
                                <div class="card-title">Tareas Pendientes</div>
                                <div class="card-value">40</div>
                            </div>

                            <div class="card small">
                                <div class="card-icon student">
                                    <svg
                                        viewBox="0 0 24 24"
                                        fill="currentColor"
                                        width="32"
                                        height="32">
                                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z" />
                                    </svg>
                                </div>
                                <div class="card-title">Tareas Entregadas</div>
                                <div class="card-value">420</div>
                            </div>

                            <div class="card small">
                                <div class="card-icon group">
                                    <svg
                                        viewBox="0 0 24 24"
                                        fill="currentColor"
                                        width="32"
                                        height="32">
                                        <path
                                            d="M1 21h22L12 2 1 21zm12-3h-2v2h2v-2zm0-6h-2v4h2v-4z" />
                                    </svg>
                                </div>
                                <div class="card-title">Tareas Vencidas</div>
                                <div class="card-value">12</div>
                            </div>
                        </div>
                        <!-- Últimas Actividades -->
                        <section class="latest-activities mt-4">
                            <h2 class="mb-3">Últimas Actividades Asignadas</h2>
                            <div class="activities-list">
                                <div class="activity-card">
                                    <div class="activity-info">
                                        <strong>Proyecto: Sistema Tutorías</strong>
                                        <p>Tarea: Completar informe de avance</p>
                                    </div>
                                    <div class="activity-time">
                                        <span>Tiempo estimado: 3 días</span>
                                    </div>
                                </div>

                                <div class="activity-card">
                                    <div class="activity-info">
                                        <strong>Proyecto: App Biblioteca</strong>
                                        <p>Tarea: Revisar interfaz de usuario</p>
                                    </div>
                                    <div class="activity-time">
                                        <span>Tiempo estimado: 2 días</span>
                                    </div>
                                </div>

                                <div class="activity-card">
                                    <div class="activity-info">
                                        <strong>Proyecto: Portal Académico</strong>
                                        <p>Tarea: Subir documentación final</p>
                                    </div>
                                    <div class="activity-time">
                                        <span>Tiempo estimado: 1 día</span>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </main>
                <?php endif; ?>

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