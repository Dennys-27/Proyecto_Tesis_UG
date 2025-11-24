<?php
require_once("../../config/conexion.php");
require_once("../../models/Ticket.php");

$ticket = new Ticket();
$ticket_id = $_GET["ticket_id"] ?? 0;

$datos = $ticket->validar_acceso($_SESSION["id_usuario"], "tickets");
if ($datos["acceso"] != 1) {
    header("Location:" . Conectar::ruta() . "views/404/");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<script>
    const USER_ID = <?= $_SESSION["id_usuario"] ?>;
</script>

<head>
    <meta charset="utf-8" />
    <title>Conversación Ticket #<?= $ticket_id ?></title>

    <?php include '../html/head.php'; ?>

    <style>
        body {
            background: #0f0f0f;
            color: #e5e5e5;
        }

        .chat-container {
            background: #151515;
            border-radius: 12px;
            padding: 20px;
            height: 70vh;
            overflow-y: auto;
            box-shadow: 0 0 20px rgba(0, 0, 0, .6);
            border: 1px solid #222;
        }

        .msg {
            padding: 12px 18px;
            border-radius: 12px;
            margin-bottom: 12px;
            width: 75%;
            position: relative;
            animation: fadeIn .3s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(5px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .yo {
            background: linear-gradient(135deg, #0066ff, #0044aa);
            margin-left: auto;
            text-align: left;
            color: #fff;
            box-shadow: 0 0 10px rgba(0, 102, 255, .4);
        }

        .otro {
            background: #242424;
            margin-right: auto;
            color: #ddd;
            border: 1px solid #333;
        }

        .msg small {
            display: block;
            margin-top: 5px;
            font-size: 11px;
            opacity: .7;
        }

        .chat-input {
            background: #111;
            border-radius: 12px;
            padding: 15px;
            box-shadow: 0 0 10px rgba(0,0,0,.4);
        }

        #mensaje {
            background: #1c1c1c;
            color: #dcdcdc;
            border: 1px solid #333;
            border-radius: 10px;
            resize: none;
        }

        #mensaje:focus {
            border-color: #0066ff;
            box-shadow: 0 0 8px rgba(0, 102, 255, .5);
        }

        .btn-enviar {
            background: #0066ff;
            border: none;
            color: white;
            border-radius: 8px;
            padding: 10px 15px;
            transition: .2s;
        }

        .btn-enviar:hover {
            background: #004fcc;
        }

        .btn-enviar svg {
            width: 22px;
            height: 22px;
        }

        .titulo-chat {
            color: #f5f5f5;
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 15px;
        }

    </style>
</head>

<body>

    <div class="app-shell">
        <?php include '../html/sidebard.php'; ?>
        <div class="main-area">
            <?php include '../html/header.php'; ?>

            <main class="content">

                <div class="page-header">
                    <h2 class="titulo-chat">Conversación del Ticket #<?= $ticket_id ?></h2>
                </div>

                <div class="container-fluid">

                    <div class="chat-container mb-3" id="chat"></div>

                    <div class="chat-input">
                        <form id="form_respuesta">
                            <input type="hidden" name="ticket_id" value="<?= $ticket_id ?>">

                            <div class="d-flex gap-2">
                                <textarea id="mensaje" name="mensaje" class="form-control" rows="2" placeholder="Escribe una respuesta..." required></textarea>

                                <button type="submit" class="btn-enviar">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M2 21l21-9L2 3v7l15 2-15 2z" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>

                </div>

            </main>

            <footer class="footer">
                <div>Universidad de Guayaquil — Ingeniería de Software</div>
                <div class="small muted"><span id="yearFooter"></span></div>
            </footer>

        </div>
    </div>

    <script src="conversation.js"></script>

</body>
</html>
