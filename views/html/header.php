<header class="topbar">
          <div class="topbar-left">
            <button
              class="btn-icon"
              id="btnToggleSidebarMobile"
              aria-label="Abrir menú"
            >
              <svg viewBox="0 0 24 24" width="20" height="20">
                <path
                  d="M3 6h18M3 12h18M3 18h18"
                  stroke="currentColor"
                  stroke-width="1.6"
                  stroke-linecap="round"
                />
              </svg>
            </button>
            <div class="top-search">
              <input
                type="search"
                placeholder="Buscar..."
                aria-label="Buscar"
                id="searchInput"
              />
            </div>
          </div>

          <div class="topbar-right">
            <div class="user" id="userMenuToggle">
              <img
                src="../../assets/img/masculino.png"
                alt="Usuario"
                class="avatar"
              />
              <div class="user-info">
                <div class="user-name"><?php echo $_SESSION["nombres"] ?></div>
                <div class="user-role small muted">Ingeniería de Software</div>
              </div>
            </div>

            <!-- Menú desplegable -->
            <div class="user-menu" id="userMenu">
              <ul>
                <li><a href="#">Perfil</a></li>
                <li><a href="../html/logout.php">Salir</a></li>
              </ul>
            </div>
          </div>
        </header>