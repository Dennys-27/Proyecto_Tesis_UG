$(document).ready(function () {

    cargar_galeria();

    // Cargar archivos en la galería
    function cargar_galeria() {

        $.get("../../controller/galeria.php?op=listar", function (data) {

            let archivos = JSON.parse(data);
            let html = "";

            archivos.forEach(item => {

                let vista = "";

                if (item.tipo.startsWith("image")) {
                    vista = `<img src="../${item.ruta_archivo}" class="thumb-img">`;
                } else {
                    vista = `
                        <div class="file-icon">
                            <i class='bx bxs-file-doc'></i>
                        </div>
                    `;
                }

                html += `
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card-galeria">
                        ${vista}
                        <div class="p-3">
                            <strong class="text-dark">${item.nombre_archivo}</strong>

                            <div class="mt-3 d-flex justify-content-between">

                                <a href="../${item.ruta_archivo}" download 
                                   class="btn btn-sm btn-primary">
                                   Descargar
                                </a>

                                <button class="btn btn-sm btn-danger btnEliminar" 
                                        data-id="${item.id_galeria}">
                                    Eliminar
                                </button>

                            </div>
                        </div>
                    </div>
                </div>`;
            });

            $("#galeria").html(html);
        });
    }

    // Botón subir
    $("#btnSubir").click(() => $("#fileInput").click());

    // Subir archivo
    $("#fileInput").change(function () {

        let formData = new FormData();
        formData.append("archivo", this.files[0]);

        $.ajax({
            url: "../../controller/galeria.php?op=subir",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,

            success: function () {
                mostrarToast("Archivo subido correctamente", "success");
                cargar_galeria();
            }
        });
    });

    // Eliminar archivo
    $(document).on("click", ".btnEliminar", function () {

        let id = $(this).data("id");

        $.post("../../controller/galeria.php?op=eliminar", { id_galeria: id }, function () {
            mostrarToast("Archivo eliminado", "danger");
            cargar_galeria();
        });

    });

});
