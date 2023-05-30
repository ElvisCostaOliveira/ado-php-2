<?php
require_once 'operacoes.php';

$dados = listarDados();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Listagem</title>
</head>
<body>
    <h1>Listagem</h1>
    <table>
        <thead>
            <tr>
                <th>Número</th>
                <th>Camas Solteiro</th>
                <th>Camas Casal</th>
                <th>Área (m²)</th>
                <th>Reservado</th>
                <th>Valor Diária</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dados as $elemento): ?>
                <tr>
                    <td><?php echo $elemento['numero']; ?></td>
                    <td><?php echo $elemento['camas_solteiro']; ?></td>
                    <td><?php echo $elemento['camas_casal']; ?></td>
                    <td><?php echo $elemento['area_m2']; ?></td>
                    <td><?php echo $elemento['reservado'] == 1 ? 'Sim' : 'Não'; ?></td>
                    <td><?php echo $elemento['valor_diaria'] / 100; ?></td>
                    <td>
                        <form method="GET" action="cadastrar.php">
                            <input type="hidden" name="chave" value="<?php echo $elemento['numero']; ?>">
                            <button type="submit">Editar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="cadastrar.php">Inserir novo elemento</a>
</body>
</html>
