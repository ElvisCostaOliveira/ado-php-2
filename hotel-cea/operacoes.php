<?php

require_once 'conecta-sqlite.php'; // Arquivo de conexão com o banco de dados

// Função para listar todos os dados da tabela "quarto"
function listarDados() {
    $pdo = conectar(); // Abre a conexão

    try {
        $query = "SELECT * FROM quarto";
        $stmt = $pdo->query($query);
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $dados;
    } catch (PDOException $e) {
        // Tratar exceção (ex.: log de erro, mensagem de erro personalizada, etc.)
        return false;
    } finally {
        $pdo = null; // Fecha a conexão
    }
}

// Função para inserir ou atualizar os dados na tabela "quarto"
function inserirAtualizarDados($numero, $camasSolteiro, $camasCasal, $areaM2, $reservado, $valorDiaria) {
    $pdo = conectar(); // Abre a conexão

    try {
        $pdo->beginTransaction(); // Inicia a transação

        $query = "SELECT COUNT(*) FROM quarto WHERE numero = :numero";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':numero', $numero);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            // Registro existente, executar UPDATE
            $query = "UPDATE quarto SET camas_solteiro = :camasSolteiro, camas_casal = :camasCasal, area_m2 = :areaM2, reservado = :reservado, valor_diaria = :valorDiaria WHERE numero = :numero";
        } else {
            // Registro não existente, executar INSERT
            $query = "INSERT INTO quarto (numero, camas_solteiro, camas_casal, area_m2, reservado, valor_diaria) 
                      VALUES (:numero, :camasSolteiro, :camasCasal, :areaM2, :reservado, :valorDiaria)";
        }
        
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':numero', $numero);
        $stmt->bindParam(':camasSolteiro', $camasSolteiro);
        $stmt->bindParam(':camasCasal', $camasCasal);
        $stmt->bindParam(':areaM2', $areaM2);
        $stmt->bindParam(':reservado', $reservado);
        $stmt->bindParam(':valorDiaria', $valorDiaria);
        $stmt->execute();

        $pdo->commit(); // Confirma a transação
        return true;
    } catch (PDOException $e) {
        $pdo->rollBack(); // Desfaz a transação em caso de erro
        // Tratar exceção (ex.: log de erro, mensagem de erro personalizada, etc.)
        return false;
    } finally {
        $pdo = null; // Fecha a conexão
    }
}

// Função para excluir os dados da tabela "quarto"
function excluirDados($numero) {
    $pdo = conectar(); // Abre a conexão

    try {
        $pdo->beginTransaction(); // Inicia a transação

        $query = "DELETE FROM quarto WHERE numero = :numero";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':numero', $numero);
        $stmt->execute();

        $pdo->commit(); // Confirma a transação
        return true;
    } catch (PDOException $e) {
        $pdo->rollBack(); // Desfaz a transação em caso de erro
        // Tratar exceção (ex.: log de erro, mensagem de erro personalizada, etc.)
        return false;
    } finally {
        $pdo = null; // Fecha a conexão
    }
}

// Função para ler os dados da tabela "quarto" a partir do número
function lerDados($numero) {
    $pdo = conectar(); // Abre a conexão

    try {
        $query = "SELECT * FROM quarto WHERE numero = :numero";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':numero', $numero);
        $stmt->execute();
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);
        return $dados;
    } catch (PDOException $e) {
        // Tratar exceção (ex.: log de erro, mensagem de erro personalizada, etc.)
        return false;
    } finally {
        $pdo = null; // Fecha a conexão
    }
}
?>
