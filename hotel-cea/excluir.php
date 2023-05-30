<?php
require_once 'operacoes.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $chave = isset($_POST['chave']) ? $_POST['chave'] : '';

    if (!empty($chave)) {
        excluirDados($chave);
    } else {
        echo 'Erro: Chave inválida.';
    }
}

header('Location: listar.php');
exit();
