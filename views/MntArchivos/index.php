<?php
require_once("../../config/conexion.php");
require_once("../../models/Galeria.php");

$galeria = new Galeria();

// Validar acceso del usuario
$datos = $galeria->validar_acceso($_SESSION["id_usuario"], "archivos");

if ($datos["acceso"] == 1) {
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Galería | Sistema de Gestión</title>

    <?php include '../html/head.php'; ?>

    <style>
        
        .card-galeria {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            background: white;
            transition: 0.25s ease;
        }
        .card-galeria:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.12);
        }
        .thumb-img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            background: #e9ecef;
        }
        .file-icon {
            font-size: 60px;
            padding: 35px 0;
            text-align: center;
            color: #0d6efd;
        }
        .filters-box {
            background: #0d0c0cff;
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            margin-bottom: 20px;
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
                    <h1 class="fw-bold">Galería de Archivos</h1>
                    <p class="muted">Sube, filtra y organiza tus archivos e imágenes.</p>
                </div>

                <div class="container-fluid">

                    <!-- BOTÓN SUBIR -->
                    <button id="btnSubir" class="btn btn-primary rounded-pill mb-3">
                        <i class="bi bi-cloud-upload"></i> Subir Archivo
                    </button>
                    <input type="file" id="fileInput" hidden>

                    <!-- FILTROS -->
                    <div class="filters-box">
                        <div class="row g-3">

                            <div class="col-md-4">
                                <input type="text" id="buscarNombre" class="form-control" placeholder="Buscar por nombre...">
                            </div>

                            <div class="col-md-3">
                                <select id="filtrarTipo" class="form-select">
                                    <option value="">Tipo de archivo</option>
                                    <option value="imagen">Imágenes</option>
                                    <option value="pdf">PDF</option>
                                    <option value="excel">Excel</option>
                                    <option value="word">Word</option>
                                    <option value="otros">Otros</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <input type="date" id="filtrarFecha" class="form-control">
                            </div>

                            <div class="col-md-2">
                                <button id="btnReset" class="btn btn-secondary w-100">
                                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                                </button>
                            </div>

                        </div>
                    </div>

                    <!-- GALERÍA -->
                    <div class="row" id="galeria"></div>

                    <!-- PAGINACIÓN -->
                    <nav class="mt-4">
                        <ul id="pagination" class="pagination justify-content-center"></ul>
                    </nav>

                </div>
            </main>

            <footer class="footer">
                <div>Universidad de Guayaquil — Ingeniería de Software</div>
                <div class="small muted"><span id="yearFooter"></span></div>
            </footer>

            <script src="../../assets/js/alertas.js"></script>
            <script src="galeria.js"></script>

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
