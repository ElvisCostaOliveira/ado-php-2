
<?php
require_once 'conecta_sqlite.php';

function excluir_quarto($numero) {
    try {
        $db = conectar();

        $stmt = $db->prepare('DELETE FROM quarto WHERE numero = ?');
        $stmt->bindParam(1, $numero);

        $stmt->execute();
    } catch (PDOException $e) {
        echo "Erro ao excluir quarto: " . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['numero'])) {
    $numero_quarto = $_GET['numero'];

    excluir_quarto($numero_quarto);

    header('Location: listar.php');
    exit;
}
?>
