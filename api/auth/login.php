<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../src/helpers/response.php';
require_once __DIR__ . '/../../src/helpers/validate.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Método não permitido.'
    ]);
    exit;
}

$dados = json_decode(file_get_contents('php://input'), true);

if (!is_array($dados)) {
    http_response_code(400);
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Dados inválidos.'
    ]);
    exit;
}

try {
    // Validar os dados do login
    $erros = validar_login($dados);

    if (!empty($erros)) {
        http_response_code(400);
        echo json_encode([
            'sucesso' => false,
            'erros' => $erros
        ]);
        exit;
    }

    $email = trim($dados['email']);
    $senha = $dados['senha'];

    // Buscar o usuário pelo e-mail
    $sql = "SELECT id, nome, email, senha_hash
            FROM usuarios
            WHERE email = :email
            LIMIT 1";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar se o usuário existe e se a senha está correta
    if (!$usuario || !password_verify($senha, $usuario['senha_hash'])) {
        http_response_code(401);
        echo json_encode([
            'sucesso' => false,
            'mensagem' => 'E-mail ou senha incorretos.'
        ]);
        exit;
    }

    // Evitar reutilização do identificador anterior da sessão
    session_regenerate_id(true);

    // Salvar os dados do usuário na sessão
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['usuario_nome'] = $usuario['nome'];

    // Responder sucesso sem retornar o hash da senha
    http_response_code(200);
    echo json_encode([
        'sucesso' => true,
        'mensagem' => 'Login realizado com sucesso.',
        'usuario' => [
            'id' => $usuario['id'],
            'nome' => $usuario['nome'],
            'email' => $usuario['email']
        ]
    ]);

} catch (PDOException $e) {
    // Não expor detalhes internos do banco de dados
    http_response_code(500);
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Erro interno do servidor.'
    ]);
}

