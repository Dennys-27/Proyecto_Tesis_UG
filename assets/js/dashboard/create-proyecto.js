document.addEventListener("DOMContentLoaded", () => {
    // --- Wizard pasos ---
    const step1Tab = new bootstrap.Tab(document.querySelector("#step1-tab"));
    const step2Tab = new bootstrap.Tab(document.querySelector("#step2-tab"));
    const step3Tab = new bootstrap.Tab(document.querySelector("#step3-tab"));
    const btnNext = document.getElementById("btnNext");
    const btnPrev = document.getElementById("btnPrev");

    let currentStep = 1;
    btnNext.addEventListener("click", () => {
        if (currentStep === 1) {
            step2Tab.show();
            currentStep = 2;
            btnPrev.disabled = false;
            btnNext.textContent = "Siguiente →";
        }
        else if (currentStep === 2) {
            step3Tab.show();
            currentStep = 3;
            btnNext.textContent = "Finalizar";
        }
        else if (currentStep === 3) {
            // Validación: todos los grupos deben tener estudiantes
            const gruposSinEstudiantes = grupos.filter(g => g.estudiantes.length === 0);
            if (gruposSinEstudiantes.length > 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Faltan estudiantes',
                    text: `El grupo "${gruposSinEstudiantes[0].nombre}" no tiene estudiantes asignados`
                });
                return;
            }

            Swal.fire({
                icon: 'success',
                title: 'Proyecto creado ✅',
                text: 'El proyecto y los grupos han sido guardados correctamente.'
            });

            const modal = bootstrap.Modal.getInstance(document.getElementById("crearProyectoModal"));
            modal.hide();

            console.log("Datos proyecto:", {
                tipo: document.getElementById("tipoProyecto").value,
                nombre: document.getElementById("nombreProyecto").value,
                grupos
            });

            // --- LIMPIAR MODAL ---
            document.getElementById("formProyecto").reset();
            inputNombreGrupo.value = "";
            listaGrupos.innerHTML = "";
            gruposContainer.innerHTML = "";
            grupos = [];
            grupoIdCounter = 1;
            activeGrupoId = null;

            // Reset wizard a paso 1
            step1Tab.show();
            currentStep = 1;
            btnPrev.disabled = true;
            btnNext.textContent = "Siguiente →";
        }

    });

    btnPrev.addEventListener("click", () => {
        if (currentStep === 2) {
            step1Tab.show();
            currentStep = 1;
            btnPrev.disabled = true;
            btnNext.textContent = "Siguiente →";
        }
        else if (currentStep === 3) {
            step2Tab.show();
            currentStep = 2;
            btnNext.textContent = "Siguiente →";
        }
    });

    // --- Grupos dinámicos ---
    let grupos = [];
    let grupoIdCounter = 1;
    let activeGrupoId = null;

    const listaGrupos = document.getElementById("listaGrupos");
    const btnCrearGrupo = document.getElementById("btnCrearGrupo");
    const inputNombreGrupo = document.getElementById("nombreGrupo");
    const gruposContainer = document.getElementById("gruposContainer"); // DIV donde pondremos cards

    btnCrearGrupo.addEventListener("click", (e) => {
        e.preventDefault();
        const nombre = inputNombreGrupo.value.trim();
        if (!nombre) return Swal.fire({ icon: 'warning', title: 'Oops...', text: 'Escribe un nombre de grupo' });

        const grupo = { id: grupoIdCounter++, nombre, estudiantes: [] };
        grupos.push(grupo);

        // Lista lateral
        const li = document.createElement("li");
        li.textContent = nombre;
        li.classList.add("mb-1", "p-1", "border", "rounded");
        li.dataset.grupoId = grupo.id;
        li.style.cursor = "pointer";
        li.onclick = () => {
            document.querySelectorAll("#listaGrupos li").forEach(x => x.classList.remove("bg-primary", "text-white"));
            li.classList.add("bg-primary", "text-white");
            activeGrupoId = grupo.id;
        }
        listaGrupos.appendChild(li);

        // Card visual del grupo
        const card = document.createElement("div");
        card.classList.add("card", "mb-2", "bg-dark", "text-white");
        card.dataset.grupoId = grupo.id;
        card.innerHTML = `
      <div class="card-body p-2">
        <strong>${grupo.nombre}</strong>
        <ul class="list-unstyled mt-1 grupo-estudiantes" style="font-size:0.9rem;"></ul>
      </div>
    `;
        gruposContainer.appendChild(card);

        inputNombreGrupo.value = "";
    });

    // --- DataTable Estudiantes ---
    $('#estudiantesTable').DataTable({
        data: [
            [1, "Ana Torres", "ana@uni.edu", "<button class='btn btn-sm btn-success asignar'>Asignar</button>"],
            [2, "Luis Pérez", "luis@uni.edu", "<button class='btn btn-sm btn-success asignar'>Asignar</button>"],
            [3, "María López", "maria@uni.edu", "<button class='btn btn-sm btn-success asignar'>Asignar</button>"]
        ],
        columns: [
            { title: "ID" }, { title: "Nombre" }, { title: "Email" }, { title: "Acción" }
        ],
        responsive: true
    });

    document.querySelector("#estudiantesTable tbody").addEventListener("click", (e) => {
        if (!e.target.classList.contains("asignar")) return;
        const row = e.target.closest("tr");
        const studentId = row.cells[0].textContent;
        const studentName = row.cells[1].textContent;

        if (!activeGrupoId) return Swal.fire({ icon: 'warning', title: 'Oops...', text: 'Selecciona un grupo primero!' });

        const grupo = grupos.find(g => g.id == activeGrupoId);
        // Evitar duplicados
        const estudianteEnOtroGrupo = grupos.some(g => g.estudiantes.some(s => s.id == studentId));
        if (estudianteEnOtroGrupo)
            return Swal.fire({ icon: 'info', title: 'Info', text: `${studentName} ya está asignado a otro grupo` });

        grupo.estudiantes.push({ id: studentId, nombre: studentName });

        // Actualizar lista en la card
        const card = gruposContainer.querySelector(`div[data-grupo-id='${grupo.id}'] ul.grupo-estudiantes`);
        const li = document.createElement("li");
        li.textContent = studentName;
        card.appendChild(li);

        Swal.fire({ icon: 'success', title: 'Asignado ✅', text: `Asignado ${studentName} a ${grupo.nombre}` });
    });
});
