<?php
require_once("../../config/conexion.php");
require_once("../../models/Rol.php");


$rol = new Rol();

// Validar acceso al dashboard
$datos = $rol->validar_acceso_rol($_SESSION["id_usuario"], "kanba");

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
                <?php if ($rol_usuario == 2): ?>
                    <main class="content">
    <!-- Header -->
    <div class="page-header d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h1 class="mb-1">Cronograma Iterativo</h1>
            <p class="mb-0 text-muted">Vista estilo Kanban con estados de las tareas</p>
        </div>
    </div>

    <!-- Kanban Board -->
    <div class="kanban-board">
        <!-- Por hacer -->
        <div class="kanban-column" data-status="todo">
            <h2>Por Hacer</h2>
            <div class="kanban-items">
                <div class="kanban-item" draggable="true">
                    📑 Generación de informes
                    <div class="tag">CRM-6</div>
                </div>
            </div>
        </div>

        <!-- En curso -->
        <div class="kanban-column" data-status="doing">
            <h2>En Curso</h2>
            <div class="kanban-items">
                <div class="kanban-item" draggable="true">
                    📝 Registro de interacciones
                    <div class="tag">CRM-3</div>
                </div>
                <div class="kanban-item" draggable="true">
                    👥 Asignación de roles
                    <div class="tag">CRM-4</div>
                </div>
            </div>
        </div>

        <!-- En revisión -->
        <div class="kanban-column" data-status="review">
            <h2>En Revisión</h2>
            <div class="kanban-items">
                <div class="kanban-item" draggable="true">
                    🔍 Registro de usuarios
                    <div class="tag">CRM-5</div>
                </div>
            </div>
        </div>

        <!-- Finalizado -->
        <div class="kanban-column" data-status="done">
            <h2>Finalizado ✔</h2>
            <div class="kanban-items"></div>
        </div>

        <!-- Crear -->
        <div class="kanban-column add">+ Crear</div>
    </div>
</main>

<style>
    .kanban-board {
        display: flex;
        gap: 1rem;
        overflow-x: auto;
        padding: 1rem 0;
    }

    .kanban-column {
        flex: 0 0 260px;
        background: #fff;
        border-radius: 8px;
        padding: 12px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.08);
        display: flex;
        flex-direction: column;
        max-height: 70vh;
    }

    .kanban-column h2 {
        font-size: 14px;
        font-weight: bold;
        margin-bottom: 10px;
        text-transform: uppercase;
        color: #555;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 6px;
    }

    .kanban-items {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: 10px;
    }

    .kanban-item {
        padding: 12px;
        background: #fdfdfd;
        border: 1px solid #eee;
        border-radius: 6px;
        cursor: grab;
        font-size: 14px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        transition: transform 0.15s ease;
    }

    .kanban-item:active {
        cursor: grabbing;
        transform: scale(1.02);
    }

    .kanban-item .tag {
        display: inline-block;
        font-size: 11px;
        font-weight: 500;
        padding: 2px 6px;
        border-radius: 4px;
        margin-top: 6px;
        background: #eee;
        color: #555;
    }

    .kanban-column.add {
        justify-content: center;
        align-items: center;
        color: #aaa;
        font-weight: bold;
        cursor: pointer;
        border: 2px dashed #ccc;
    }

    .highlight {
        border: 2px dashed #007bff;
        background: #f0f8ff;
    }
</style>

<script>
    const items = document.querySelectorAll('.kanban-item');
    const columns = document.querySelectorAll('.kanban-items');

    items.forEach(item => {
        item.addEventListener('dragstart', () => {
            item.classList.add('dragging');
        });
        item.addEventListener('dragend', () => {
            item.classList.remove('dragging');
        });
    });

    columns.forEach(column => {
        column.addEventListener('dragover', e => {
            e.preventDefault();
            const dragging = document.querySelector('.dragging');
            column.classList.add('highlight');
            column.appendChild(dragging);
        });
        column.addEventListener('dragleave', () => {
            column.classList.remove('highlight');
        });
        column.addEventListener('drop', () => {
            column.classList.remove('highlight');
        });
    });
</script>


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
                <script>
                    // Animación con scroll
                    const items = document.querySelectorAll(".timeline-item");

                    function showOnScroll() {
                    items.forEach(item => {
                        const rect = item.getBoundingClientRect();
                        if (rect.top < window.innerHeight - 100) {
                        item.classList.add("visible");
                        }
                    });
                    }
                    window.addEventListener("scroll", showOnScroll);
                    showOnScroll();

                    // Iteración activa según fecha
                    const today = new Date("2025-09-09"); // <- aquí iría new Date() en producción
                    items.forEach(item => {
                    const dateAttr = item.getAttribute("data-date");
                    const date = new Date(dateAttr);
                    if (today >= date) {
                        item.classList.add("active");
                    }
                    });

                    // Navegación paso a paso
                    let currentStep = 0;
                    const nextBtn = document.getElementById("nextBtn");

                    nextBtn.addEventListener("click", () => {
                    if (currentStep < items.length) {
                        items[currentStep].scrollIntoView({ behavior: "smooth", block: "center" });
                        items[currentStep].classList.add("active");
                        currentStep++;
                    } else {
                        currentStep = 0;
                    }
                    });

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