<?php
    require_once("../../models/Menu.php");
    $menu = new Menu();
    $datos = $menu->getMenuByRol($_SESSION["id_rol"]);
?>
<aside class="sidebar" id="sidebar" aria-label="Barra lateral">
    <!-- Top del sidebar: Logo + botón cerrar -->
    <div class="sidebar-top">
        <div class="brand">
            <img src="../../assets/img/Logo-UG-2016.png" alt="Logo UG" class="brand-logo" />
            <div class="brand-text">
                <div class="brand-title">UG - Gestión</div>
                <div class="brand-sub">Proyectos Curriculares</div>
            </div>
        </div>

        <!-- Botón cerrar/abrir -->
        <button class="btn-icon collapse-btn" id="btnToggleSidebar" title="Cerrar menú">
            <svg class="icon icon-close" viewBox="0 0 24 24" width="18" height="18">
                <path d="M6 6L18 18M6 18L18 6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" fill="none" />
            </svg>
        </button>
    </div>

    <!-- Navegación principal -->
    <nav class="nav" aria-label="Dashboard Estudiante">
        <ul>
            <?php
            // $menus = $menuModel->getMenuByRol($id_rol); // traído desde el controlador
            foreach($datos as $item):
                // Puedes usar $active para marcar la página actual
                $isActive = isset($active) && $active == $item['nombre'] ? 'active' : '';
            ?>
                <li class="nav-item <?= $isActive ?>">
                    <a href="<?= $item['link'] ?>">
                        <span class="icon">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="<?= $item['icono'] ?>"></path>
                            </svg>
                        </span>
                        <?php if(!empty($item['badge'])): ?>
                            <span class="badge"><?= $item['badge'] ?></span>
                        <?php endif; ?>
                        <span class="label"><?= $item['nombre'] ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <!-- Resizer handle -->
    <div class="resizer" id="sidebarResizer" title="Arrastra para cambiar ancho"></div>

    <!-- Footer -->
    <div class="sidebar-footer">
        <div class="small muted">Universidad de Guayaquil</div>
        <div class="copyright">© <span id="year"></span></div>
    </div>
</aside>
