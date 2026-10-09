<?php

function validar_cadastro(array $dados): array
{
    $erros = [];

    // Validar nome obrigatório e remover espaços extras
    $nome = trim($dados['nome'] ?? '');

    if ($nome === '') {
        $erros[] = 'O nome é obrigatório.';
    }

    // Validar e-mail
    $email = trim($dados['email'] ?? '');

    if ($email === '') {
        $erros[] = 'O e-mail é obrigatório.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros[] = 'O e-mail informado é inválido.';
    }

    // Validar senha
    $senha = $dados['senha'] ?? '';

    if ($senha === '') {
        $erros[] = 'A senha é obrigatória.';
    } elseif (strlen($senha) < 8) {
        $erros[] = 'A senha deve ter no mínimo 8 caracteres.';
    }

    return $erros;
}

function validar_login(array $dados): array
{
    $erros = [];

    // Validar e-mail
    $email = trim($dados['email'] ?? '');

    if ($email === '') {
        $erros[] = 'O e-mail é obrigatório.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros[] = 'O e-mail informado é inválido.';
    }

    // Validar senha
    $senha = $dados['senha'] ?? '';

    if ($senha === '') {
        $erros[] = 'A senha é obrigatória.';
    }

    return $erros;
}