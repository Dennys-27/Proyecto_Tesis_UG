<?php
require_once("../../config/conexion.php");
require_once("../../models/Rol.php");


$rol = new Rol();

// Validar acceso al dashboard
$datos = $rol->validar_acceso_rol($_SESSION["id_usuario"], "dashboard");

if ($datos["acceso"] == 1) {
    $rol_usuario = $_SESSION['id_rol'];
?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Dashboard - Sistema de Gestión</title>

        <?php include '../html/head.php'; ?>
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
                <?php if ($rol_usuario == 1): ?>
                    <main class="content">
                        <div class="page-header">
                            <h1>Tablero</h1>
                            <p class="muted">
                                Bienvenido al sistema de gestión — aquí tienes un resumen rápido.
                            </p>
                        </div>

                        <div class="grid">
                            <div class="card small">
                                <div class="card-icon download">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M5 20h14v-2H5v2zm7-18l-5 5h3v4h4V7h3l-5-5z" />
                                    </svg>
                                </div>
                                <div class="card-title">Descargas</div>
                                <div class="card-value">345</div>
                            </div>

                            <div class="card small">
                                <div class="card-icon users">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-3.3 0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z" />
                                    </svg>
                                </div>
                                <div class="card-title">Usuarios</div>
                                <div class="card-value">120</div>
                            </div>

                            <div class="card small">
                                <div class="card-icon teacher">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M12 12c2.2 0 4-1.8 4-4s-1.8-4-4-4-4 1.8-4 4 1.8 4 4 4zm0 2c-2.7 0-8 1.3-8 4v2h16v-2c0-2.7-5.3-4-8-4z" />
                                    </svg>
                                </div>
                                <div class="card-title">Docentes</div>
                                <div class="card-value">35</div>
                            </div>

                            <div class="card small">
                                <div class="card-icon student">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-3.3 0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z" />
                                    </svg>
                                </div>
                                <div class="card-title">Estudiantes</div>
                                <div class="card-value">420</div>
                            </div>

                            <div class="card small">
                                <div class="card-icon professor">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-3.3 0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z" />
                                    </svg>
                                </div>
                                <div class="card-title">Profesores</div>
                                <div class="card-value">40</div>
                            </div>

                            <div class="card small">
                                <div class="card-icon image">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M21 19V5c0-1.1-.9-2-2-2H5C3.9 3 3 3.9 3 5v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z" />
                                    </svg>
                                </div>
                                <div class="card-title">Imágenes</div>
                                <div class="card-value">560</div>
                            </div>
                        </div>

                        <section class="panel">
                            <h2>Rendimiento mensual</h2>
                            <canvas id="dashboardChart" width="400" height="200"></canvas>
                        </section>
                    </main>
                <?php endif; ?>




                <!-- PAGE CONTENT -->
                <?php if ($rol_usuario == 3): ?>
                    <main class="content">
                        <!-- Header -->
                        <div class="page-header">
                            <h1>Dashboard Docente</h1>
                            <p class="muted">Resumen de tus grupos, proyectos y actividades.</p>
                            <!-- Botón -->
                            <button
                                type="button"
                                class="btn btn-accent btn-success btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#crearProyectoModal">
                                + Crear Proyecto
                            </button>
                        </div>

                        <!-- Cards -->
                        <div class="grid">
                            <div class="card small">
                                <div class="card-icon group">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M12 12c2.2 0 4-1.8 4-4s-1.8-4-4-4-4 1.8-4 4 1.8 4 4 4zm0 2c-2.7 0-8 1.3-8 4v2h16v-2c0-2.7-5.3-4-8-4z" />
                                    </svg>
                                </div>
                                <div class="card-title">Grupos</div>
                                <div class="card-value">12</div>
                            </div>

                            <div class="card small">
                                <div class="card-icon student">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-3.3 0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z" />
                                    </svg>
                                </div>
                                <div class="card-title">Estudiantes</div>
                                <div class="card-value">420</div>
                            </div>

                            <div class="card small warning">
                                <div class="card-icon">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M1 21h22L12 2 1 21zm12-3h-2v2h2v-2zm0-6h-2v4h2v-4z" />
                                    </svg>
                                </div>
                                <div class="card-title">Advertencia</div>
                                <div class="card-value">2 proyectos sin calificar</div>
                            </div>
                        </div>

                        <!-- Row con tabla y acciones -->
                        <div class="row mt-4">
                            <!-- Tabla -->
                            <div class="col-lg-7 col-md-12 mb-4">
                                <section class="panel h-100">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h2>Proyectos pendientes</h2>
                                    </div>

                                    <table
                                        id="projectsTable"
                                        class="table table-striped table-hover"
                                        style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>Proyecto</th>
                                                <th>Grupo</th>
                                                <th>Estado</th>
                                                <th>Última Actividad</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="table-warning">
                                                <td>Sistema Tutorías</td>
                                                <td>Grupo B</td>
                                                <td>En revisión</td>
                                                <td>Hace 5 días</td>
                                                <td>
                                                    <a href="#" class="btn btn-primary btn-sm">Evaluar</a>
                                                </td>
                                            </tr>
                                            <tr class="table-danger">
                                                <td>App Biblioteca</td>
                                                <td>Grupo C</td>
                                                <td>Retrasado</td>
                                                <td>Hace 10 días</td>
                                                <td>
                                                    <a href="#" class="btn btn-primary btn-sm">Evaluar</a>
                                                </td>
                                            </tr>
                                            <tr class="table-success">
                                                <td>Portal Académico</td>
                                                <td>Grupo A</td>
                                                <td>Aceptado</td>
                                                <td>Hace 2 días</td>
                                                <td>
                                                    <a href="#" class="btn btn-secondary btn-sm">Ver</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </section>
                            </div>

                            <!-- Gráfico de rendimiento -->
                            <div class="col-lg-5 col-md-12 mb-4">
                                <section
                                    class="panel h-100 d-flex flex-column justify-content-center">
                                    <h2>Rendimiento por grupos</h2>
                                    <canvas id="groupChartProyect" height="200"></canvas>
                                </section>
                            </div>

                            <!-- Gráfico estudiantes -->
                            <div class="row mt-4">
                                <div class="col-6">
                                    <section class="panel">
                                        <h2>Indicadores por estudiantes</h2>
                                        <canvas id="studentChart" height="120"></canvas>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </main>

                    <!-- Modal -->
                    <div
                        class="modal fade"
                        id="crearProyectoModal"
                        tabindex="-1"
                        aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered">
                            <div class="modal-content modal-dark position-relative">
                                <!-- Fondo visual -->
                                <div class="modal-bg-image"></div>
                                <div class="modal-header border-0">
                                    <h5 class="modal-title text-white">Nuevo Proyecto</h5>
                                </div>
                                <div class="modal-body position-relative" style="z-index: 10">
                                    <!-- Nav de pasos -->
                                    <ul
                                        class="nav nav-tabs nav-dark"
                                        id="wizardTabs"
                                        role="tablist">
                                        <li class="nav-item">
                                            <button
                                                class="nav-link active"
                                                id="step1-tab"
                                                data-bs-toggle="tab"
                                                data-bs-target="#step1"
                                                type="button">
                                                1. Datos Proyecto
                                            </button>
                                        </li>
                                        <li class="nav-item">
                                            <button
                                                class="nav-link"
                                                id="step2-tab"
                                                data-bs-toggle="tab"
                                                data-bs-target="#step2"
                                                type="button">
                                                2. Crear Grupo
                                            </button>
                                        </li>
                                        <li class="nav-item">
                                            <button
                                                class="nav-link"
                                                id="step3-tab"
                                                data-bs-toggle="tab"
                                                data-bs-target="#step3"
                                                type="button">
                                                3. Asignar Estudiantes
                                            </button>
                                        </li>
                                    </ul>
                                    <div class="tab-content mt-3">
                                        <!-- Paso 1: Datos del Proyecto -->
                                        <div class="tab-pane fade show active" id="step1">
                                            <form id="formProyecto">
                                                <!-- Tipo de Proyecto -->
                                                <div class="mb-3">
                                                    <label for="tipoProyecto" class="form-label text-white">Tipo de Proyecto</label>
                                                    <select
                                                        class="form-select form-dark"
                                                        id="tipoProyecto"
                                                        required>
                                                        <option value="">-- Seleccionar --</option>
                                                        <option value="fci">FCI</option>
                                                        <option value="desarrollo">Desarrollo</option>
                                                        <option value="tecnologico">Tecnológico</option>
                                                    </select>
                                                </div>
                                                <!-- Nombre del Proyecto -->
                                                <div class="mb-3">
                                                    <label
                                                        for="nombreProyecto"
                                                        class="form-label text-white">Nombre del Proyecto</label>
                                                    <input
                                                        type="text"
                                                        class="form-control form-dark"
                                                        id="nombreProyecto"
                                                        placeholder="Escribe el nombre"
                                                        required />
                                                </div>
                                                <!-- Descripción -->
                                                <div class="mb-3">
                                                    <label
                                                        for="descripcionProyecto"
                                                        class="form-label text-white">Descripción</label>
                                                    <!-- Contenedor del editor -->
                                                    <div id="editorDescripcion"></div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- Paso 2: Crear Grupos -->
                                        <div class="tab-pane fade" id="step2">
                                            <div class="mb-3">
                                                <label class="text-white mb-2">Crear Grupo</label>
                                                <div class="input-group input-group-sm mb-2">
                                                    <input
                                                        type="text"
                                                        id="nombreGrupo"
                                                        class="form-control form-dark"
                                                        placeholder="Nombre del grupo" />
                                                    <button
                                                        class="btn btn-accent btn-success"
                                                        id="btnCrearGrupo">
                                                        Crear Grupo
                                                    </button>
                                                </div>
                                                <ul id="listaGrupos" class="text-white"></ul>
                                                <!-- Contenedor para las cards de grupos -->
                                                <div id="gruposContainer" class="mt-3"></div>
                                            </div>
                                        </div>
                                        <!-- Paso 3: Asignar Estudiantes -->
                                        <div class="tab-pane fade" id="step3">
                                            <p class="text-white mb-2">
                                                Selecciona un grupo en la lista para asignar estudiantes.
                                            </p>
                                            <table
                                                id="estudiantesTable"
                                                class="table table-dark table-striped table-bordered"
                                                style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Nombre</th>
                                                        <th>Email</th>
                                                        <th>Acción</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="modal-footer border-0 position-relative"
                                    style="z-index: 10">
                                    <button
                                        type="button"
                                        id="btnPrev"
                                        class="btn btn-secondary"
                                        disabled>
                                        ← Atrás
                                    </button>
                                    <button type="button" id="btnNext" class="btn btn-accent">
                                        Siguiente →
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>


             

                <?php if ($rol_usuario == 4): ?>
                    <!-- PAGE CONTENT -->
                    <main class="content">
                        <div class="page-header">
                            <h1>Tablero</h1>
                            <p class="muted">
                                Bienvenido al sistema de gestión — aquí tienes un resumen rápido.
                            </p>
                        </div>

                        <div class="grid">
                            <div class="card small">
                                <div class="card-icon professor">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-3.3 0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z" />
                                    </svg>
                                </div>
                                <div class="card-title">Profesores</div>
                                <div class="card-value">40</div>
                            </div>

                            <div class="card small">
                                <div class="card-icon student">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-3.3 0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z" />
                                    </svg>
                                </div>
                                <div class="card-title">Estudiantes</div>
                                <div class="card-value">420</div>
                            </div>

                            <div class="card small">
                                <div class="card-icon group">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M12 12c2.2 0 4-1.8 4-4s-1.8-4-4-4-4 1.8-4 4 1.8 4 4 4zm0 2c-2.7 0-8 1.3-8 4v2h16v-2c0-2.7-5.3-4-8-4z" />
                                    </svg>
                                </div>
                                <div class="card-title">Grupos</div>
                                <div class="card-value">12</div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <!-- Columna izquierda: DataTable -->
                            <div class="col-lg-7 col-md-12 mb-4">
                                <section class="panel h-100">
                                    <h2>Proyectos pendientes / aceptados</h2>
                                    <table
                                        id="projectsTable"
                                        class="table table-striped table-hover"
                                        style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>Proyecto</th>
                                                <th>Grupo</th>
                                                <th>Profesor</th>
                                                <th>Estado</th>
                                                <th>Tiempo (hrs)</th>
                                                <th>Validar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="table-success">
                                                <td>Portal Académico</td>
                                                <td>Grupo A</td>
                                                <td>Dr. Pérez</td>
                                                <td>Aceptado</td>
                                                <td>1</td>
                                                <td class="text-center">
                                                    <a
                                                        href="#"
                                                        class="btn btn-primary btn-sm"
                                                        title="Visualizar">
                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            width="18"
                                                            height="18"
                                                            fill="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path
                                                                d="M21 16V3H3v13h18zm0-15c1.1 0 2 .9 2 2v13c0 1.1-.9 2-2 2h-7v2h2v2H8v-2h2v-2H3c-1.1 0-2-.9-2-2V3c0-1.1.9-2 2-2h18z" />
                                                        </svg>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr class="table-warning">
                                                <td>Sistema Tutorías</td>
                                                <td>Grupo B</td>
                                                <td>Dr. López</td>
                                                <td>En revisión</td>
                                                <td>3</td>
                                                <td class="text-center">
                                                    <a
                                                        href="#"
                                                        class="btn btn-primary btn-sm"
                                                        title="Visualizar">
                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            width="18"
                                                            height="18"
                                                            fill="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path
                                                                d="M21 16V3H3v13h18zm0-15c1.1 0 2 .9 2 2v13c0 1.1-.9 2-2 2h-7v2h2v2H8v-2h2v-2H3c-1.1 0-2-.9-2-2V3c0-1.1.9-2 2-2h18z" />
                                                        </svg>
                                                    </a>
                                                </td>
                                            </tr>

                                            <tr class="table-danger">
                                                <td>App Biblioteca</td>
                                                <td>Grupo C</td>
                                                <td>Dra. Ruiz</td>
                                                <td>Retrasado</td>
                                                <td>5</td>
                                                <td class="text-center">
                                                    <a
                                                        href="#"
                                                        class="btn btn-primary btn-sm"
                                                        title="Visualizar">
                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            width="18"
                                                            height="18"
                                                            fill="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path
                                                                d="M21 16V3H3v13h18zm0-15c1.1 0 2 .9 2 2v13c0 1.1-.9 2-2 2h-7v2h2v2H8v-2h2v-2H3c-1.1 0-2-.9-2-2V3c0-1.1.9-2 2-2h18z" />
                                                        </svg>
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </section>
                            </div>

                            <!-- Columna derecha: Gráfico -->
                            <div class="col-lg-5 col-md-12 mb-4">
                                <section
                                    class="panel h-100 d-flex flex-column justify-content-center">
                                    <h2>Rendimiento mensual</h2>
                                    <canvas id="groupChart" width="400" height="200"></canvas>
                                </section>
                            </div>
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
                    var quill = new Quill("#editorDescripcion", {
                        theme: "snow",
                        placeholder: "Escribe la descripción del proyecto...",
                        modules: {
                            toolbar: [
                                [{
                                    header: [1, 2, false]
                                }],
                                ["bold", "italic", "underline"],
                                ["link", "image"],
                                [{
                                    list: "ordered"
                                }, {
                                    list: "bullet"
                                }]
                            ]
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