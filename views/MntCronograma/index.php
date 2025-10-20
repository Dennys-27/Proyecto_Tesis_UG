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
            /* Timeline */
            .timeline {
            position: relative;
            margin: 2rem auto;
            padding-left: 40px;
            border-left: 3px solid #444;
            max-width: 800px;
            }

            .timeline-item {
            position: relative;
            margin-bottom: 2rem;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease;
            }

            .timeline-item.visible {
            opacity: 1;
            transform: translateY(0);
            }

            .timeline-item.active .timeline-icon {
            background: linear-gradient(145deg, #00c6ff, #0072ff);
            box-shadow: 0 0 15px rgba(0, 150, 255, 0.7);
            }

            .timeline-icon {
            position: absolute;
            left: -32px;
            top: 0;
            width: 40px;
            height: 40px;
            background: linear-gradient(145deg, #4a4a7a, #2a2a4a);
            color: #fff;
            border-radius: 50%;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            }

            .timeline-content {
            background: linear-gradient(120deg, #3c3c61, #2e2e50);
            padding: 1rem 1.5rem;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            transition: transform 0.2s, box-shadow 0.3s;
            }

            .timeline-content:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.5);
            }

            .timeline-date {
            font-size: 0.85rem;
            color: #aaa;
            display: block;
            margin-top: 0.5rem;
            }

            /* Botón dinámico */
            .btn-dynamic {
            background: linear-gradient(135deg, #0072ff, #00c6ff);
            border: none;
            color: #fff;
            padding: 0.7rem 1.5rem;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.3s;
            }

            .btn-dynamic:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 150, 255, 0.6);
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
                <?php if ($rol_usuario == 2): ?>
                    <main class="content">
                        <div class="page-header mb-4">
                            <h1 class="mb-1 text-white">Cronograma Iterativo</h1>
                            <p class="ttext-white mb-0">Explora las fases de tu proyecto de forma dinámica.</p>
                        </div>

                        <section class="timeline" id="timeline">
                            <!-- Iteraciones -->
                            <div class="timeline-item" data-date="2025-09-01">
                            <div class="timeline-icon">1</div>
                            <div class="timeline-content">
                                <h5>Iteración 1: Análisis</h5>
                                <p>Recolección de requisitos y reuniones iniciales con el cliente.</p>
                                <span class="timeline-date">01 - 07 Sept 2025</span>
                            </div>
                            </div>

                            <div class="timeline-item" data-date="2025-09-08">
                            <div class="timeline-icon">2</div>
                            <div class="timeline-content">
                                <h5>Iteración 2: Diseño</h5>
                                <p>Creación de diagramas, wireframes y arquitectura de software.</p>
                                <span class="timeline-date">08 - 15 Sept 2025</span>
                            </div>
                            </div>

                            <div class="timeline-item" data-date="2025-09-16">
                            <div class="timeline-icon">3</div>
                            <div class="timeline-content">
                                <h5>Iteración 3: Desarrollo</h5>
                                <p>Implementación de módulos principales y pruebas unitarias.</p>
                                <span class="timeline-date">16 - 25 Sept 2025</span>
                            </div>
                            </div>

                            <div class="timeline-item" data-date="2025-09-26">
                            <div class="timeline-icon">4</div>
                            <div class="timeline-content">
                                <h5>Iteración 4: Entrega</h5>
                                <p>Pruebas finales, documentación y despliegue del sistema.</p>
                                <span class="timeline-date">26 - 30 Sept 2025</span>
                            </div>
                            </div>
                        </section>

                        <div class="text-center mt-4">
                            <button id="nextBtn" class="btn-dynamic">➡ Siguiente Iteración</button>
                        </div>
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