<?php

define('DB_HOST', 'localhost');
define('DB_PORT', '5432');
define('DB_NAME', 'taskflow_rw');
define('DB_USER', 'postgres');
define('DB_PASS', 'postgre');

try {
    $dsn = "pgsql:host=" . DB_HOST .
           ";port=" . DB_PORT .
           ";dbname=" . DB_NAME;

    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    header('Content-Type: application/json; charset=UTF-8');

    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Erro interno do servidor.'
    ], JSON_UNESCAPED_UNICODE);

    exit;
}