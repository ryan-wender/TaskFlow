<?php

require_once __DIR__ . '/../../src/helpers/response.php';
require_once __DIR__ . '/../../config/database.php';

$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo !== 'GET') {
    json_response(
        false,
        'Método não permitido.',
        null,
        405
    );
}

try {
    $sql = "SELECT id, nome, email, created_at
            FROM users
            ORDER BY id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute();

    $usuarios = $stmt->fetchAll();

    json_response(
        true,
        'Usuários listados com sucesso.',
        $usuarios,
        200
    );

} catch (PDOException $e) {
    json_response(
        false,
        'Erro interno do servidor.',
        null,
        500
    );
}