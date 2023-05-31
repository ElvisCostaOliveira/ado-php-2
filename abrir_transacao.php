<?php
require_once 'conecta_sqlite.php';

try {
    $db = conectar();

    $db->beginTransaction();

    $db->commit();

    echo "Transação aberta com sucesso!";
} catch (PDOException $e) {
    $db->rollBack();

    echo "Erro ao abrir transação: " . $e->getMessage();
}
?>
