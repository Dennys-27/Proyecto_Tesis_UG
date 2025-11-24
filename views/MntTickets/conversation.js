let ticket_id = $('input[name="ticket_id"]').val();

function cargarConversacion() {
    $.post("../../controller/ticket.php?op=listar_conversacion", 
    { ticket_id: ticket_id }, 
    function(data) {

        let mensajes = JSON.parse(data);
        let html = "";

        mensajes.forEach(msg => {
            let clase = msg.remitente_id == USER_ID ? "yo" : "otro";

            html += `
                <div class="msg ${clase}">
                    ${msg.mensaje}
                    <small>${msg.usuario_nombre} • ${msg.fecha_envio}</small>
                </div>
            `;
        });

        $("#chat").html(html);
        $("#chat").scrollTop($("#chat")[0].scrollHeight);
    });
}

// Enviar
$("#form_respuesta").on("submit", function(e) {
    e.preventDefault();

    $.post("../../controller/ticket.php?op=enviar",
    $(this).serialize(),
    function(resp) {
        $("#mensaje").val("");
        cargarConversacion();
    });
});

// Cargar cada 3s
setInterval(cargarConversacion, 3000);
cargarConversacion();
