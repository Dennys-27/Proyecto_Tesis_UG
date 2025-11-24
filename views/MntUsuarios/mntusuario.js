function init(){
    $("#mantenimiento_form").on("submit",function(e){
        guardaryeditar(e);
    });
}

function guardaryeditar(e){
    e.preventDefault();
    var formData = new FormData($("#mantenimiento_form")[0]);
    $.ajax({
        url:"../../controller/rol.php?op=guardaryeditar",
        type:"POST",
        data:formData,
        contentType:false,
        processData:false,
        success:function(data){
            $('#table_data').DataTable().ajax.reload();
            $('#modalmantenimiento').modal('hide');

            swal.fire({
                title:'Rol',
                text: 'Registro Confirmado',
                icon: 'success'
            });
        }
    });
}


$(document).ready(function () {

    $('#table_data').DataTable({

        // Procesamiento y servidor
        aProcessing: true,
        aServerSide: true,

        // Botones de exportación
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5'
        ],

        // Llamada AJAX
        ajax: {
            url: "../../controller/usuario.php?op=listar",
            type: "post",
            dataType: "json",
            error: function (e) {
                console.log(e.responseText);
            }
        },

        // Configuración adicional
        bDestroy: true,
        responsive: true,
        bInfo: true,
        iDisplayLength: 10,
        order: [[0, "desc"]],

        // Idioma
        language: {
            sProcessing: "Procesando...",
            sLengthMenu: "Mostrar _MENU_ registros",
            sZeroRecords: "No se encontraron resultados",
            sEmptyTable: "Ningún dato disponible en esta tabla",
            sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
            sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
            sSearch: "Buscar:",
            sLoadingRecords: "Cargando...",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Último",
                sNext: "Siguiente",
                sPrevious: "Anterior"
            },
            oAria: {
                sSortAscending: ": Activar para ordenar la columna de manera ascendente",
                sSortDescending: ": Activar para ordenar la columna de manera descendente"
            }
        }

    });

});

function editar(id_rol){
    $.post("../../controller/rol.php?op=mostrar",{rol_id:id_rol},function(data){
        data=JSON.parse(data);
        $('#rol_id').val(data.id_rol);
        $('#nombre').val(data.nombre);
    });
    $('#lbltitulo').html('Editar Registro');
    $('#modalmantenimiento').modal('show');
}


function eliminar(rol_id){
    swal.fire({
        title:"Eliminar!",
        text:"Desea Eliminar el Registro?",
        icon: "error",
        confirmButtonText : "Si",
        showCancelButton : true,
        cancelButtonText: "No",
    }).then((result)=>{
        if (result.value){
            $.post("../../controller/rol.php?op=eliminar",{rol_id:rol_id},function(data){
                console.log(data);
            });

            $('#table_data').DataTable().ajax.reload();

            swal.fire({
                title:'Rol',
                text: 'Registro Eliminado',
                icon: 'success'
            });
        }
    });
}


function activar(rol_id){
    swal.fire({
        title:"Activar!",
        text:"Desea Activar el Registro?",
        icon: "question",
        confirmButtonText : "Si",
        showCancelButton : true,
        cancelButtonText: "No",
    }).then((result)=>{
        if (result.value){
            $.post("../../controller/rol.php?op=activar",{rol_id:rol_id},function(data){
                console.log(data);
            });

            $('#table_data').DataTable().ajax.reload();

            swal.fire({
                title:'Rol',
                text: 'Registro Eliminado',
                icon: 'success'
            });
        }
    });
}



function editar(rol_id){

    console.log("🔵 Enviando rol_id:", rol_id);

    $.post("../../controller/rol.php?op=mostrar",{rol_id:rol_id},function(data){

        console.log("🟠 DATA RECIBIDA DEL SERVER (antes de parsear):", data);

        try {
            let json = JSON.parse(data);
            console.log("🟢 JSON PARSEADO:", json);

            // IDs correctos del formulario
            $('#rol_id').val(json.id_rol);  // hidden
            $('#nombre').val(json.nombre);  // input texto

        } catch (error) {
            console.error("❌ ERROR AL PARSEAR JSON:", error);
        }

    });

    $('#lbltitulo').html('Editar Registro');
    $('#modalmantenimiento').modal('show');
}


$(document).on("click","#btnnuevo",function(){
    $('#rol_id').val('');
    $('#rol_nom').val('');
    $('#lbltitulo').html('Nuevo Registro');
    $("#mantenimiento_form")[0].reset();
    $('#modalmantenimiento').modal('show');
});

init();
