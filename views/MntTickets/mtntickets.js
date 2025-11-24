$(document).ready(function(){

    // Inicializar DataTable
    var tabla = $('#table_data').DataTable({
        "processing": true,
        "serverSide": false, // si quieres serverSide cambia y ajusta controller
        "ajax": {
            url: "../../controller/ticket.php?op=listar",
            type: "POST"
        },
        "columns": [
            { "data": 0 },
            { "data": 1 },
            { "data": 2 },
            { "data": 3 },
            { "data": 4 },
            { "data": 5 },
            { "data": 6 },
            { "data": 7 },
            { "data": 8 }
        ],
        responsive: true
    });

    // Abrir modal nuevo
    $('#btnnuevo').on('click', function(){
        $('#ticket_form')[0].reset();
        $('#ticket_id').val('');
        $('#lbltitulo').text('Nuevo Ticket');
        $('#modalmantenimiento').modal('show');
    });

    // Guardar / Editar
    $('#ticket_form').on('submit', function(e){
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: '../../controller/ticket.php?op=guardaryeditar',
            type: 'POST',
            data: formData,
            success: function(res){
                try{
                    var r = JSON.parse(res);
                } catch(err){
                    // si el controlador ya devuelve json con header, puede venir como objeto
                    var r = (typeof res === 'object') ? res : {status: 'ok'};
                }
                $('#modalmantenimiento').modal('hide');
                Swal.fire('Tickets', 'Operación exitosa', 'success');
                $('#table_data').DataTable().ajax.reload();
            },
            error: function(xhr, status, error){
                console.error(xhr.responseText);
                Swal.fire('Error', 'No se pudo guardar el ticket', 'error');
            }
        });
    });

});

// Funciones globales

function editar(ticket_id){
    console.log("Editar:", ticket_id);
    $.post("../../controller/ticket.php?op=mostrar", { ticket_id: ticket_id }, function(data){
        console.log("raw:", data);
        try {
            var json = (typeof data === 'object') ? data : JSON.parse(data);
        } catch(e){
            console.error("Error parsear mostrar:", e, data);
            Swal.fire('Error', 'Respuesta inválida del servidor', 'error');
            return;
        }

        $('#ticket_id').val(json.ticket_id);
        $('#titulo').val(json.titulo);
        $('#categoria').val(json.categoria);
        $('#descripcion').val(json.descripcion);

        $('#lbltitulo').text('Editar Ticket');
        $('#modalmantenimiento').modal('show');
    });
}

function ver(ticket_id){
    // Puedes abrir modal de solo lectura o redirect a detalle
    $.post("../../controller/ticket.php?op=mostrar", { ticket_id: ticket_id }, function(data){
        var json = (typeof data === 'object') ? data : JSON.parse(data);
        // Muestra alerta rápida (puedes diseñar modal de detalle)
        Swal.fire({
            title: json.titulo,
            html: '<b>Categoría:</b> ' + json.categoria + '<br/><br/>' + json.descripcion,
            width: 700
        });
    });
}

function eliminar(ticket_id){
    Swal.fire({
        title: 'Eliminar?',
        text: "¿Desea eliminar este ticket?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar'
    }).then((result) => {
        if(result.isConfirmed){
            $.post("../../controller/ticket.php?op=eliminar", { ticket_id: ticket_id }, function(data){
                console.log("elim:", data);
                $('#table_data').DataTable().ajax.reload();
                Swal.fire('Eliminado','El ticket fue eliminado','success');
            });
        }
    });
}


function responder(ticket_id){
    window.open("conversation.php?ticket_id=" + ticket_id, "_blank");
}
