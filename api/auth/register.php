
<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../src/helpers/response.php';
require_once __DIR__ . '/../../src/helpers/validate.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Responder erro 405
    json_response
      
    ;
}

$dados = json_decode(file_get_contents('php://input'), true);

try {
    // Validar os dados e responder 422 se houver erros
    if (!is_array($dados)) {
        json_response
     
    }

    $erros = validar_cadastro($dados);

    if (!empty($erros)) {
        json_response

    $nome = trim($dados['nome']);
    $email = trim($dados['email']);
    $senha = $dados['senha'];

    // Consultar se o e-mail já existe
    $sql = "SELECT id FROM usuarios WHERE email = :email LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);

    if ($stmt->fetch(PDO::FETCH_ASSOC)) {
        json_response
    
    }

    // Gerar o hash da senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Preparar e executar o INSERT com parâmetros
    $sql = "INSERT INTO usuarios (nome, email, senha_hash)
            VALUES (:nome, :email, :senha_hash)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'nome' => $nome,
        'email' => $email,
        'senha_hash' => $senha_hash
    ]);

    // Responder com sucesso sem retornar senha_hash
    json_response

 {
    // Não expor detalhes internos do banco
    json_response;
