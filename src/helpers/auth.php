<?php

require_once __DIR__ . '/response.php';

function verificar_autenticacao(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        // TODO: iniciar a sessão
    }

    if (empty($_SESSION['usuario_id'])) {
        // TODO: responder erro 401 com json_response
    }
}

