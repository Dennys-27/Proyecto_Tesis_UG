const activities = [
  { proyecto: "Sistema Tutorías", tarea: "Completar informe de avance", tiempo: "3 días", fecha: "2025-08-20" },
  { proyecto: "App Biblioteca", tarea: "Revisar interfaz de usuario", tiempo: "2 días", fecha: "2025-08-22" },
  { proyecto: "Portal Académico", tarea: "Subir documentación final", tiempo: "1 día", fecha: "2025-08-25" },
  { proyecto: "Plataforma E-learning", tarea: "Diseñar cuestionario", tiempo: "5 días", fecha: "2025-08-27" },
  { proyecto: "Sistema Inventario", tarea: "Validar módulo de reportes", tiempo: "4 días", fecha: "2025-08-28" },
  { proyecto: "Chat Universitario", tarea: "Configurar notificaciones", tiempo: "2 días", fecha: "2025-08-29" }
];

const itemsPerPage = 3;
let currentPage = 1;
let filteredActivities = [...activities];

const activitiesList = document.getElementById("activitiesList");
const pageInfo = document.getElementById("pageInfo");

// ========= Modal =========
const actividadModalEl = document.getElementById("actividadModal");
const btnPrevActividad = document.getElementById("btnPrevActividad");
const btnNextActividad = document.getElementById("btnNextActividad");
const btnEntregarActividad = document.getElementById("btnEntregarActividad");

let currentStep = 1;
let currentActivityIndex = null; // Para saber cuál se entrega

function resetActividadModal() {
  currentStep = 1;
  btnPrevActividad.disabled = true;
  btnNextActividad.style.display = "inline-block";
  btnEntregarActividad.style.display = "none";

  // reset input file
  document.getElementById("archivoActividad").value = "";
}

// ========== Renderizar Actividades ==========
function renderActivities() {
  activitiesList.innerHTML = "";

  const start = (currentPage - 1) * itemsPerPage;
  const end = start + itemsPerPage;
  const paginated = filteredActivities.slice(start, end);

  paginated.forEach((act, index) => {
    const card = document.createElement("div");
    card.classList.add("activity-card");
    card.innerHTML = `
      <div class="activity-info">
        <strong>Proyecto: ${act.proyecto}</strong>
        <p>Tarea: ${act.tarea}</p>
        <div class="activity-time">⏱ ${act.tiempo}</div>
      </div>
      <div class="activity-actions">
        <button data-id="${index}" class="btn btn-primary btn-sm btn-realizar">
          Realizar actividad
        </button>
      </div>
    `;
    activitiesList.appendChild(card);
  });

  pageInfo.textContent = `Página ${currentPage} de ${Math.ceil(filteredActivities.length / itemsPerPage)}`;

  document.getElementById("prevPage").disabled = currentPage === 1;
  document.getElementById("nextPage").disabled = currentPage === Math.ceil(filteredActivities.length / itemsPerPage);

  // Eventos -> abrir modal
  document.querySelectorAll(".btn-realizar").forEach(btn => {
    btn.addEventListener("click", (e) => {
      const id = e.target.dataset.id;
      const act = paginated[id]; // actividad actual
      currentActivityIndex = start + parseInt(id); // guardamos índice global

      // Rellenamos modal
      document.getElementById("modalProyecto").textContent = act.proyecto;
      document.getElementById("modalTarea").textContent = act.tarea;
      document.getElementById("modalTiempo").textContent = act.tiempo;
      document.getElementById("modalFecha").textContent = act.fecha;

      // Mostramos modal
      const modal = new bootstrap.Modal(actividadModalEl);
      modal.show();
    });
  });
}

// ========= Botones Modal =========
btnNextActividad.addEventListener("click", () => {
  if (currentStep === 1) {
    document.querySelector("#info-tab").classList.remove("active");
    document.querySelector("#info").classList.remove("show", "active");
    document.querySelector("#entrega-tab").classList.add("active");
    document.querySelector("#entrega").classList.add("show", "active");

    currentStep = 2;
    btnPrevActividad.disabled = false;
    btnNextActividad.style.display = "none";
    btnEntregarActividad.style.display = "inline-block";
  }
});

btnPrevActividad.addEventListener("click", () => {
  if (currentStep === 2) {
    document.querySelector("#entrega-tab").classList.remove("active");
    document.querySelector("#entrega").classList.remove("show", "active");
    document.querySelector("#info-tab").classList.add("active");
    document.querySelector("#info").classList.add("show", "active");

    currentStep = 1;
    btnPrevActividad.disabled = true;
    btnNextActividad.style.display = "inline-block";
    btnEntregarActividad.style.display = "none";
  }
});

btnEntregarActividad.addEventListener("click", () => {
  const file = document.getElementById("archivoActividad").files[0];
  if (!file) {
    alert("Por favor selecciona un archivo antes de entregar.");
    return;
  }

  // Marcar como entregada -> la quitamos de la lista
  filteredActivities.splice(currentActivityIndex, 1);

  alert(`Actividad entregada con éxito ✅: ${file.name}`);

  const modal = bootstrap.Modal.getInstance(actividadModalEl);
  modal.hide();

  // Re-renderizar lista
  if (currentPage > Math.ceil(filteredActivities.length / itemsPerPage)) {
    currentPage = 1;
  }
  renderActivities();
});

actividadModalEl.addEventListener("hidden.bs.modal", resetActividadModal);

// ========= Paginación =========
document.getElementById("prevPage").addEventListener("click", () => {
  if (currentPage > 1) {
    currentPage--;
    renderActivities();
  }
});

document.getElementById("nextPage").addEventListener("click", () => {
  if (currentPage < Math.ceil(filteredActivities.length / itemsPerPage)) {
    currentPage++;
    renderActivities();
  }
});

// ========= Filtros =========
document.getElementById("applyFilters").addEventListener("click", () => {
  const search = document.getElementById("searchInput").value.toLowerCase();
  const from = document.getElementById("dateFrom").value;
  const to = document.getElementById("dateTo").value;
  const sort = document.getElementById("sortFilter").value;

  filteredActivities = activities.filter((act) => {
    const matchSearch =
      act.proyecto.toLowerCase().includes(search) ||
      act.tarea.toLowerCase().includes(search);

    const matchDate =
      (!from || act.fecha >= from) && (!to || act.fecha <= to);

    return matchSearch && matchDate;
  });

  filteredActivities.sort((a, b) =>
    sort === "recent" ? b.fecha.localeCompare(a.fecha) : a.fecha.localeCompare(b.fecha)
  );

  currentPage = 1;
  renderActivities();
});

// ========= Inicial =========
renderActivities();
