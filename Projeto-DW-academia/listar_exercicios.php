<?php
session_start();
require_once 'conexao.php';

// Verifica se o admin está logado (se houver controle de sessão)
if (!isset($_SESSION["admin"])) {
    // header("Location: login.php");
    // exit;
}

// Consulta todos os exercícios
$sql = "SELECT * FROM exercicio ORDER BY id_exercicio DESC";
$comando = mysqli_prepare($conexao, $sql);
mysqli_stmt_execute($comando);
$resultados = mysqli_stmt_get_result($comando);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Listar Exercícios</title>
<style>
    :root {
        --neon-green-light: #39ff14;
        --neon-green-dark: #00b300;
        --bg-dark: #0a0a0a;
        --card-bg: #111111;
        --text-light: #ffffff;
        --text-label: #cccccc;
        --neon-shadow-medium: rgba(57, 255, 20, 0.6);
        --radius: 8px;
    }

    body {
        font-family: Arial, sans-serif;
        background-color: var(--bg-dark);
        color: var(--text-light);
        margin: 0;
        padding: 40px;
    }

    h2 {
        text-align: center;
        color: var(--neon-green-light);
        text-shadow: 0 0 10px var(--neon-green-light);
        margin-bottom: 30px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background-color: var(--card-bg);
        box-shadow: 0 0 20px rgba(57, 255, 20, 0.15);
        border-radius: var(--radius);
        overflow: hidden;
    }

    th, td {
        padding: 14px;
        text-align: center;
        border-bottom: 1px solid #222;
    }

    th {
        background-color: var(--neon-green-dark);
        color: #000;
        font-weight: bold;
        text-transform: uppercase;
    }

    tr:hover {
        background-color: #1a1a1a;
    }

    a.botao {
        padding: 8px 14px;
        border-radius: var(--radius);
        color: var(--bg-dark);
        text-decoration: none;
        font-weight: bold;
        margin: 2px;
        display: inline-block;
        background: linear-gradient(to right, var(--neon-green-dark), var(--neon-green-light));
        box-shadow: 0 0 8px var(--neon-shadow-medium);
        transition: 0.3s;
    }

    a.botao:hover {
        background: var(--neon-green-light);
        box-shadow: 0 0 12px var(--neon-shadow-medium);
        transform: translateY(-2px);
    }

    .excluir {
        background: linear-gradient(to right, #ff3914, #ff5c33);
        color: #fff;
    }

    .excluir:hover {
        background: #ff3914;
        box-shadow: 0 0 12px rgba(255, 57, 20, 0.6);
    }

    .novo {
        display: inline-block;
        margin-bottom: 20px;
        text-decoration: none;
        font-weight: bold;
        padding: 12px 20px;
        border-radius: var(--radius);
        background: linear-gradient(to right, var(--neon-green-dark), var(--neon-green-light));
        color: var(--bg-dark);
        box-shadow: 0 0 10px var(--neon-shadow-medium);
        transition: 0.3s;
    }

    .novo:hover {
        background: var(--neon-green-light);
        transform: scale(1.05);
    }
</style>
</head>
<body>

<h2>Lista de Exercícios</h2>

<a href="exercicio.php" class="novo">+ Novo Exercício</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome do Exercício</th>
            <th>Séries</th>
            <th>Repetições</th>
            <th>Carga (kg)</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($exercicio = mysqli_fetch_assoc($resultados)) { ?>
        <tr>
            <td><?= $exercicio['id_exercicio'] ?></td>
            <td><?= htmlspecialchars($exercicio['nome_exercicio']) ?></td>
            <td><?= $exercicio['series'] ?></td>
            <td><?= $exercicio['repeticoes'] ?></td>
            <td><?= number_format($exercicio['carga'], 2, ',', '.') ?></td>
            <td>
                <a href="exercicio.php?id=<?= $exercicio['id_exercicio'] ?>" class="botao">Editar</a>
                <a href="excluir_exercicio.php?id=<?= $exercicio['id_exercicio'] ?>" class="botao excluir" onclick="return confirm('Deseja realmente excluir este exercício?')">Excluir</a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

</body>
</html>
