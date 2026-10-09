
<?php

require_once __DIR__ . '/../../src/helpers/response.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Método não permitido.'
    ]);
    exit;
}

session_start();

// Limpar o array $_SESSION
$_SESSION = [];

// Excluir o cookie de sessão quando estiver em uso
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();

    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}

// Destruir os dados da sessão
session_destroy();

// Responder que o logout foi concluído
http_response_code(200);
echo json_encode([
    'sucesso' => true,
    'mensagem' => 'Logout realizado com sucesso.'
]);