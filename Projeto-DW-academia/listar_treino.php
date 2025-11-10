<?php
session_start();
require_once 'conexao.php';

// Verifica se o admin está logado (se houver controle de sessão)
if (!isset($_SESSION["admin"])) {
    // header("Location: login.php");
    // exit;
}

// Consulta todos os exercícios
$sql = "SELECT * FROM treino ORDER BY id_treino DESC";
$comando = mysqli_prepare($conexao, $sql);
mysqli_stmt_execute($comando);
$resultados = mysqli_stmt_get_result($comando);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Listar Treinos</title>
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

        th,
        td {
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

    <h2>Lista de Treinos</h2>

    <a href="treino.php" class="novo">+ Novo Treino</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome do Treino</th>
                <th>Descricao do Treino</th>
                <th>Ação</th>
            </tr>
        </thead>
        <?php
        echo '<tbody>';
        while ($treino = mysqli_fetch_assoc($resultados)) {
            echo '<tr>';
            echo '<td>' . $treino['id_treino'] . '</td>';
            echo '<td>' . htmlspecialchars($treino['nome_treino']) . '</td>';
            echo '<td>' . $treino['descricao'] . '</td>';
            echo '<td>';
            echo '<a href="treino.php?id=' . $treino['id_treino'] . '" class="botao">Editar</a> ';
            echo '<a href="excluir_treino.php?id=' . $treino['id_treino'] . '" class="botao excluir" onclick="return confirm(\'¿Desea realmente eliminar este entrenamiento?\')">Excluir</a>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '<a href="dashboard.php" class="novo">Voltar</a>';
        ?>

    </table>

    <li><a href="dashboard.php"><span></span>

</body>

</html>