<?php
require_once 'operacoes.php';

// Função para verificar se todos os campos obrigatórios foram preenchidos
function validarCampos($camasSolteiro, $camasCasal, $areaM2, $reservado, $valorDiaria) {
    if ($camasSolteiro <= 0 || $camasCasal < 0 || $areaM2 <= 0 || $valorDiaria <= 0) {
        return false;
    }
    return true;
}

// Verifica se é uma inserção ou uma alteração
$chave = isset($_GET['chave']) ? $_GET['chave'] : '';
$acao = empty($chave) ? 'inserir' : 'alterar';

// Inicializa as variáveis dos campos com valores padrão
$numero = '';
$camasSolteiro = 0;
$camasCasal = 0;
$areaM2 = 0;
$reservado = 0;
$valorDiaria = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validação dos campos
    $camasSolteiro = isset($_POST['camasSolteiro']) ? $_POST['camasSolteiro'] : 0;
    $camasCasal = isset($_POST['camasCasal']) ? $_POST['camasCasal'] : 0;
    $areaM2 = isset($_POST['areaM2']) ? $_POST['areaM2'] : 0;
    $reservado = isset($_POST['reservado']) ? $_POST['reservado'] : 0;
    $valorDiaria = isset($_POST['valorDiaria']) ? $_POST['valorDiaria'] : 0;

    if (!validarCampos($camasSolteiro, $camasCasal, $areaM2, $reservado, $valorDiaria)) {
        echo 'Erro: Dados inválidos.';
    } else {
        // Inserção ou alteração dos dados
        if ($acao === 'inserir') {
            inserirAtualizarDados(null, $camasSolteiro, $camasCasal, $areaM2, $reservado, $valorDiaria);
        } elseif ($acao === 'alterar') {
            if (!empty($chave)) {
                alterarDados($chave, $camasSolteiro, $camasCasal, $areaM2, $reservado, $valorDiaria);
                header('Location: listar.php');
                exit();
            } else {
                echo 'Erro: Chave inválida.';
            }
        }
    }
} elseif ($acao === 'alterar') {
    // Recupera os dados do elemento a ser alterado
    if (!empty($chave)) {
        $dados = lerDados($chave);

        if ($dados) {
            $numero = $dados['numero'];
            $camasSolteiro = $dados['camas_solteiro'];
            $camasCasal = $dados['camas_casal'];
            $areaM2 = $dados['area_m2'];
            $reservado = $dados['reservado'];
            $valorDiaria = $dados['valor_diaria'];
        } else {
            echo 'Erro: Dados não encontrados.';
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastrar</title>
</head>
<body>
    <h1>Cadastrar</h1>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <?php if ($acao === 'alterar'): ?>
            <input type="hidden" name="chave" value="<?php echo $chave; ?>">
        <?php endif; ?>
        <label for="camasSolteiro">Camas Solteiro:</label>
        <input type="number" name="camasSolteiro" id="camasSolteiro" value="<?php echo $camasSolteiro; ?>" required>
        <br>
        <label for="camasCasal">Camas Casal:</label>
        <input type="number" name="camasCasal" id="camasCasal" value="<?php echo $camasCasal; ?>" required>
        <br>
        <label for="areaM2">Área (m²):</label>
        <input type="number" name="areaM2" id="areaM2" value="<?php echo $areaM2; ?>" required>
        <br>
        <label for="reservado">Reservado:</label>
        <select name="reservado" id="reservado">
            <option value="0" <?php echo $reservado === '0' ? 'selected' : ''; ?>>Não</option>
            <option value="1" <?php echo $reservado === '1' ? 'selected' : ''; ?>>Sim</option>
        </select>
        <br>
        <label for="valorDiaria">Valor Diária (em reais):</label>
        <input type="number" name="valorDiaria" id="valorDiaria" value="<?php echo $valorDiaria; ?>" required>
        <br>
        <button type="submit"><?php echo $acao === 'inserir' ? 'Inserir' : 'Alterar'; ?></button>
    </form>

    <?php if ($acao === 'alterar'): ?>
        <form method="POST" action="excluir.php">
            <input type="hidden" name="chave" value="<?php echo $chave; ?>">
            <button type="submit" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</button>
        </form>
    <?php endif; ?>

    <a href="listar.php">Voltar para a Listagem</a>
</body>
</html>
