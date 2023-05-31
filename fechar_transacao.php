<?php
require_once 'conecta_sqlite.php';

try {
    $db = conectar();

    $db->commit();

    echo "Transação fechada com sucesso!";
} catch (PDOException $e) {
    echo "Erro ao fechar transação: " . $e->getMessage();
}
?>
