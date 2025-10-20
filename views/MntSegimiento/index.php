<?php
require_once("../../config/conexion.php");
require_once("../../models/Rol.php");


$rol = new Rol();

// Validar acceso al dashboard
$datos = $rol->validar_acceso_rol($_SESSION["id_usuario"], "seguimiento");

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
            /* Columnas estilo Kanban */
            .kanban-board {
                display: flex;
                gap: 1rem;
                overflow-x: auto;
                padding-bottom: 1rem;
            }

            .kanban-column {
                min-width: 220px;
                max-width: 300px;
                background: linear-gradient(145deg, #2f2f4f, #23233a);
                flex-shrink: 0;
                border-radius: 12px;
                padding: 1rem;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
                transition: background 0.3s, transform 0.2s;
            }

            .kanban-column:hover {
                transform: translateY(-2px);
            }

            .kanban-column h5 {
                font-size: 1rem;
                font-weight: 600;
                border-bottom: 1px solid rgba(255, 255, 255, 0.2);
                padding-bottom: 0.5rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
                color: #f1f1f1;
            }

            /* Tarjetas de tareas */
            .kanban-card {
                background: linear-gradient(120deg, #3c3c61, #2e2e50);
                color: #fff;
                padding: 1rem;
                margin-bottom: 0.75rem;
                border-radius: 10px;
                cursor: grab;
                transition: transform 0.2s, box-shadow 0.3s, background 0.3s;
                box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
            }

            .kanban-card:hover {
                transform: translateY(-5px) scale(1.02);
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
            }

            /* Prioridades */
            .kanban-card.alta {
                border-left: 5px solid #e74c3c;
            }

            .kanban-card.media {
                border-left: 5px solid #f1c40f;
            }

            .kanban-card.baja {
                border-left: 5px solid #2ecc71;
            }

            /* Drag over highlight */
            .kanban-column.drag-over {
                background: linear-gradient(145deg, #3a3a61, #2a2a48);
            }

            /* Scroll horizontal moderno */
            .kanban-board::-webkit-scrollbar {
                height: 8px;
            }

            .kanban-board::-webkit-scrollbar-thumb {
                background-color: #777;
                border-radius: 10px;
            }

            .kanban-board::-webkit-scrollbar-track {
                background-color: #1e1e2f;
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
                <main class="content p-4">
                    <div class="page-header mb-4">
                        <h1 class="mb-1 text-white">Tablero de Avances</h1>
                        <p class="mb-0" style="color: #fff;">Organiza y visualiza las actividades de tus proyectos en columnas.</p>
                    </div>

                    <section class="kanban-board d-flex flex-wrap gap-3" id="kanbanBoard">
                        <!-- Columnas -->
                        <div class="kanban-column bg-dark rounded-3 p-3 flex-fill" data-status="por-hacer">
                            <h5 class="mb-3 text-white">Por Hacer <span class="contador">0</span></h5>
                        </div>

                        <div class="kanban-column bg-dark rounded-3 p-3 flex-fill" data-status="en-curso">
                            <h5 class="mb-3 text-white">En Curso <span class="contador">0</span></h5>
                        </div>

                        <div class="kanban-column bg-dark rounded-3 p-3 flex-fill" data-status="en-revision">
                            <h5 class="mb-3 text-white">En Revisión <span class="contador">0</span></h5>
                        </div>

                        <div class="kanban-column bg-dark rounded-3 p-3 flex-fill" data-status="finalizado">
                            <h5 class="mb-3 text-white">Finalizado <span class="contador">0</span></h5>
                        </div>
                    </section>
                </main>






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
                <script>
                    const columns = document.querySelectorAll(".kanban-column");

                    // Datos de ejemplo
                    const tareas = [{
                            id: 1,
                            texto: "Generar informe de avances",
                            status: "por-hacer",
                            prioridad: "alta"
                        },
                        {
                            id: 2,
                            texto: "Revisar requisitos del cliente",
                            status: "por-hacer",
                            prioridad: "media"
                        },
                        {
                            id: 3,
                            texto: "Documentación de requerimientos",
                            status: "en-curso",
                            prioridad: "media"
                        },
                        {
                            id: 4,
                            texto: "Pruebas unitarias",
                            status: "en-revision",
                            prioridad: "alta"
                        },
                        {
                            id: 5,
                            texto: "Diseño de base de datos",
                            status: "finalizado",
                            prioridad: "baja"
                        }
                    ];

                    // Función para renderizar tareas
                    function renderTareas() {
                        columns.forEach(col => {
                            col.innerHTML = `<h5 class="mb-3 text-white">${col.getAttribute('data-status').replace('-', ' ')} <span class="contador">0</span></h5>`;
                        });

                        tareas.forEach(tarea => {
                            const card = document.createElement("div");
                            card.classList.add("kanban-card", tarea.prioridad);
                            card.setAttribute("draggable", true);
                            card.dataset.id = tarea.id;
                            card.textContent = tarea.texto;
                            document.querySelector(`.kanban-column[data-status="${tarea.status}"]`).appendChild(card);
                        });

                        updateContadores();
                    }

                    // Drag & Drop
                    let dragged;

                    document.addEventListener("dragstart", e => {
                        if (e.target.classList.contains("kanban-card")) {
                            dragged = e.target;
                            e.dataTransfer.effectAllowed = "move";
                        }
                    });

                    document.addEventListener("dragover", e => {
                        if (e.target.classList.contains("kanban-column")) {
                            e.preventDefault();
                            e.target.classList.add("drag-over");
                        }
                    });

                    document.addEventListener("dragleave", e => {
                        if (e.target.classList.contains("kanban-column")) {
                            e.target.classList.remove("drag-over");
                        }
                    });

                    document.addEventListener("drop", e => {
                        if (e.target.classList.contains("kanban-column")) {
                            e.preventDefault();
                            e.target.classList.remove("drag-over");
                            const tareaId = dragged.dataset.id;
                            const nuevaCol = e.target.dataset.status;
                            // Actualizar estado de la tarea
                            const tarea = tareas.find(t => t.id == tareaId);
                            tarea.status = nuevaCol;
                            renderTareas();
                        }
                    });

                    // Contadores
                    function updateContadores() {
                        columns.forEach(col => {
                            const count = col.querySelectorAll(".kanban-card").length;
                            col.querySelector(".contador").textContent = count;
                        });
                    }

                    // Inicializar tablero
                    renderTareas();
                </script>


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