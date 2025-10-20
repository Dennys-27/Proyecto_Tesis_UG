document.addEventListener('DOMContentLoaded', () => {
  const sidebar = document.getElementById('sidebar');
  const appShell = document.querySelector('.app-shell');
  const btnMobile = document.getElementById('btnToggleSidebarMobile'); // ☰
  const btnClose = document.getElementById('btnToggleSidebar');       // ✖
  const overlay = document.getElementById('overlay');
  const userToggle = document.getElementById('userMenuToggle');
  const BREAKPOINT = 880;

  if (!sidebar || !btnMobile) return; // elementos mínimos

  const isMobile = () => window.innerWidth <= BREAKPOINT;

  const setBodyScrollLock = (lock) => {
    document.body.style.overflow = lock ? 'hidden' : '';
  };

  // --- Desktop: toggle collapsed state (also keep appShell in sync) ---
  const toggleSidebarDesktop = () => {
    sidebar.classList.toggle('collapsed');
    if (appShell) {
      appShell.classList.toggle('sidebar-collapsed');
    }
  };

  // --- Mobile: open / close with overlay and body lock ---
  const openSidebarMobile = () => {
    sidebar.classList.add('open');
    if (overlay) overlay.classList.add('visible');
    setBodyScrollLock(true);
  };

  const closeSidebarMobile = () => {
    sidebar.classList.remove('open');
    if (overlay) overlay.classList.remove('visible');
    setBodyScrollLock(false);
  };

  // --- Eventos ---
  // ☰ en la topbar: abrir en móvil / colapsar en escritorio
  btnMobile.addEventListener('click', () => {
    if (isMobile()) {
      openSidebarMobile();
    } else {
      toggleSidebarDesktop();
    }
  });

  // ✖ dentro del sidebar: en móvil cierra, en escritorio colapsa
  if (btnClose) {
    btnClose.addEventListener('click', () => {
      if (isMobile()) {
        closeSidebarMobile();
      } else {
        toggleSidebarDesktop();
      }
    });
  }

  // Clic en overlay -> cerrar (móvil)
  if (overlay) {
    overlay.addEventListener('click', () => closeSidebarMobile());
  }

  // Tecla Escape -> cierra menú móvil si está abierto
  document.addEventListener('keydown', (e) => {
    if ((e.key === 'Escape' || e.key === 'Esc') && isMobile() && sidebar.classList.contains('open')) {
      closeSidebarMobile();
    }
  });

  // Al redimensionar: limpiar estados móviles y sincronizar appShell con sidebar.collapsed
  window.addEventListener('resize', () => {
    if (!isMobile()) {
      // salir de modo móvil si hubiera quedado
      closeSidebarMobile();
      // asegurar que appShell refleje el estado collapsed actual
      if (appShell) {
        if (sidebar.classList.contains('collapsed')) appShell.classList.add('sidebar-collapsed');
        else appShell.classList.remove('sidebar-collapsed');
      }
    } else {
      // si estamos en móvil, quitamos cualquier clase que dependa del appShell
      if (appShell) appShell.classList.remove('sidebar-collapsed');
    }
  });

  // Inicializar: sincronizar appShell con el estado actual del sidebar al cargar
  if (appShell) {
    if (sidebar.classList.contains('collapsed')) appShell.classList.add('sidebar-collapsed');
    else appShell.classList.remove('sidebar-collapsed');
  }

   if (userToggle && userMenu) {
    userToggle.addEventListener('click', () => {
      userMenu.style.display = userMenu.style.display === 'block' ? 'none' : 'block';
    });

    // Cerrar si se hace click fuera
    document.addEventListener('click', (e) => {
      if (!userToggle.contains(e.target) && !userMenu.contains(e.target)) {
        userMenu.style.display = 'none';
      }
    });
  }
});
