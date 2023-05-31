<?php
require_once 'conecta_sqlite.php';

function inserir_quarto($dados) {
    try {
        $db = conectar();

        $stmt = $db->prepare('INSERT INTO quarto (camas_solteiro, camas_casal, area_m2, reservado, valor_diaria) VALUES (?, ?, ?, ?, ?)');
        $stmt->bindParam(1, $dados['camas_solteiro']);
        $stmt->bindParam(2, $dados['camas_casal']);
        $stmt->bindParam(3, $dados['area_m2']);
        $stmt->bindParam(4, $dados['reservado']);
        $stmt->bindParam(5, $dados['valor_diaria']);

        $stmt->execute();
    } catch (PDOException $e) {
        echo "Erro ao inserir quarto: " . $e->getMessage();
    }
}

function alterar_quarto($dados) {
    try {
        $db = conectar();

        $stmt = $db->prepare('UPDATE quarto SET camas_solteiro = ?, camas_casal = ?, area_m2 = ?, reservado = ?, valor_diaria = ? WHERE numero = ?');
        $stmt->bindParam(1, $dados['camas_solteiro']);
        $stmt->bindParam(2, $dados['camas_casal']);
        $stmt->bindParam(3, $dados['area_m2']);
        $stmt->bindParam(4, $dados['reservado']);
        $stmt->bindParam(5, $dados['valor_diaria']);
        $stmt->bindParam(6, $dados['numero']);

        $stmt->execute();
    } catch (PDOException $e) {
        echo "Erro ao alterar quarto: " . $e->getMessage();
    }
}
?>
