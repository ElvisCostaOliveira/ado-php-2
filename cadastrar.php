<?php
require_once 'conecta_sqlite.php';
require_once 'validacoes.php';
require_once 'operacoes.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = $_POST;

    if (validar_dados($dados)) {
        if (isset($dados['numero'])) {
            alterar_quarto($dados);
        } else {
            inserir_quarto($dados);
        }
        header('Location: listar.php');
        exit;
    } else {
        echo "Dados inválidos. Verifique os valores informados.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inserir/Alterar Quarto</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css\style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php
    $alteracao = false;
    $dados_quarto = array();
    if (isset($_GET['numero'])) {
        $alteracao = true;
        $numero_quarto = $_GET['numero'];
        try {
            $db = conectar();
            $stmt = $db->prepare('SELECT * FROM quarto WHERE numero = ?');
            $stmt->bindParam(1, $numero_quarto);
            $stmt->execute();
            $dados_quarto = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao consultar quarto: " . $e->getMessage();
        }
    }
    ?>

<div class="container">
        <h1><?php echo $alteracao ? 'Alterar' : 'Inserir'; ?> Quarto</h1>
        
        <form action="cadastrar.php" method="POST">
            <?php if ($alteracao) : ?>
                <input type="hidden" name="numero" value="<?php echo $dados_quarto['numero']; ?>">
            <?php endif; ?>

            <div class="form-group">
                <label for="camas_solteiro">Camas de Solteiro:</label>
                <input type="number" class="form-control" name="camas_solteiro" value="<?php echo $alteracao ? $dados_quarto['camas_solteiro'] : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="camas_casal">Camas de Casal:</label>
                <input type="number" class="form-control" name="camas_casal" value="<?php echo $alteracao ? $dados_quarto['camas_casal'] : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="area_m2">Área (m²):</label>
                <input type="number" class="form-control" name="area_m2" value="<?php echo $alteracao ? $dados_quarto['area_m2'] : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="reservado">Reservado:</label>
                <select class="form-control" name="reservado" required>
                    <option value="0" <?php echo $alteracao && $dados_quarto['reservado'] == 0 ? 'selected' : ''; ?>>Não</option>
                    <option value="1" <?php echo $alteracao && $dados_quarto['reservado'] == 1 ? 'selected' : ''; ?>>Sim</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="valor_diaria">Valor Diária:</label>
                <input type="number" class="form-control" name="valor_diaria" value="<?php echo $alteracao ? $dados_quarto['valor_diaria'] : ''; ?>" required>
            </div>

            <?php if ($alteracao) : ?>
                <button type="submit" class="btn btn-primary">Alterar</button>
                <button type="button" class="btn btn-danger" onclick="confirmarExclusao()">Excluir</button>
            <?php else : ?>
                <button type="submit" class="btn btn-primary">Inserir</button>
            <?php endif; ?>

            <a href="listar.php?" class="btn btn-primary">Voltar</a>
        </form>
        
        <?php if ($alteracao) : ?>
            <script>
                function confirmarExclusao() {
                    if (confirm("Tem certeza que deseja excluir o quarto?")) {
                        window.location.href = "excluir.php?numero=<?php echo $numero_quarto; ?>";
                    }
                }
            </script>
        <?php endif; ?>
    </div>
    

    <!-- Add Bootstrap JS (jQuery is required for some Bootstrap components) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
