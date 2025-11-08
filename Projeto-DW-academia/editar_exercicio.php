<?php
require_once "conexao.php";




?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Gerenciar Exercicios</title>

</head>
<body>

<h2><?= $editar_id ? "Editar Exercicio" : "Cadastrar Exercicio" ?></h2>

<form method="post">
    <input type="hidden" name="id_exercicio" value="<?= $editar_id ?>">
    Nome: <input type="text" name="nome_exercicio" value="<?= $editar_nome ?>" required><br>
    Series: <input type="number" name="series" value="<?= $editar_series ?>" required><br>
    Repeticoes: <input type="number" name="repeticoes" value="<?= $editar_repeticoes ?>" required><br>
    Carga (kg): <input type="number" step="0.01" name="carga" value="<?= $editar_carga ?>" required><br>
    <?php if ($editar_id) { ?>
        <button type="submit" name="salvar_edicao">Salvar Alteracoes</button>
        <a href="exercicio.php">Cancelar</a>
    <?php } else { ?>
        <button type="submit" name="cadastrar">Cadastrar</button>
    <?php } ?>
</form>

</body>
</html>
