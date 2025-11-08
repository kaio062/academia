<?php
require_once "conexao.php";

// Cadastrar exercício
if (isset($_POST["cadastrar"])) {
    $nome = $_POST["nome_exercicio"];
    $series = $_POST["series"];
    $repeticoes = $_POST["repeticoes"];
    $carga = $_POST["carga"];
    $sql = "INSERT INTO exercicio (nome_exercicio, series, repeticoes, carga)
            VALUES ('$nome', '$series', '$repeticoes', '$carga')";
    $conexao->query($sql);
}

// Editar exercício
if (isset($_POST["editar"])) {
    $id = $_POST["id_exercicio"];
    $nome = $_POST["nome_exercicio"];
    $series = $_POST["series"];
    $repeticoes = $_POST["repeticoes"];
    $carga = $_POST["carga"];
    $sql = "UPDATE exercicio 
            SET nome_exercicio='$nome', series='$series', repeticoes='$repeticoes', carga='$carga'
            WHERE id_exercicio='$id'";
    $conexao->query($sql);
}

// Deletar exercício
if (isset($_GET["deletar"])) {
    $id = $_GET["deletar"];
    $sql = "DELETE FROM exercicio WHERE id_exercicio='$id'";
    $conexao->query($sql);
}

// Listar todos
$resultado = $conexao->query("SELECT * FROM exercicio");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Gerenciar Exercícios</title>
</head>
<body>
<h2>Cadastrar Exercício</h2>
<form method="post">
    Nome: <input type="text" name="nome_exercicio" required><br>
    Séries: <input type="number" name="series" required><br>
    Repetições: <input type="number" name="repeticoes" required><br>
    Carga (kg): <input type="number" step="0.01" name="carga" required><br>
    <button type="submit" name="cadastrar">Cadastrar</button>
</form>

<h2>Lista de Exercícios</h2>
<table border="1">
<tr>
    <th>ID</th><th>Nome</th><th>Séries</th><th>Repetições</th><th>Carga</th><th>Ações</th>
</tr>
<?php while ($linha = $resultado->fetch_assoc()) { ?>
<tr>
    <td><?= $linha["id_exercicio"] ?></td>
    <td><?= $linha["nome_exercicio"] ?></td>
    <td><?= $linha["series"] ?></td>
    <td><?= $linha["repeticoes"] ?></td>
    <td><?= $linha["carga"] ?></td>
    <td>
        <a href="?deletar=<?= $linha["id_exercicio"] ?>">Excluir</a>
    </td>
</tr>
<?php } ?>
</table>
<style>
    /* === Estilo Base === */
    body {
        background-color: #0d0d0d;
        color: #00ff80;
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 40px;
    }

    h2 {
        color: #00ff80;
        text-shadow: 0 0 10px #00ff80;
        margin-bottom: 15px;
    }

    /* === Formulário === */
    form {
        background-color: #1a1a1a;
        border: 1px solid #00ff80;
        border-radius: 10px;
        padding: 20px;
        width: 350px;
        margin-bottom: 30px;
        box-shadow: 0 0 15px rgba(0, 255, 128, 0.2);
    }

    input {
        background-color: #0d0d0d;
        border: 1px solid #00ff80;
        color: #00ff80;
        padding: 8px;
        border-radius: 6px;
        margin: 5px 0 10px 0;
        width: 100%;
        box-sizing: border-box;
        font-size: 14px;
    }

    input:focus {
        outline: none;
        box-shadow: 0 0 10px #00ff80;
    }

    button {
        background-color: #00ff80;
        border: none;
        color: #0d0d0d;
        font-weight: bold;
        padding: 10px 15px;
        border-radius: 6px;
        cursor: pointer;
        transition: 0.2s;
        width: 100%;
    }

    button:hover {
        background-color: #00cc66;
        box-shadow: 0 0 10px #00ff80;
    }

    /* === Tabela === */
    table {
        width: 100%;
        border-collapse: collapse;
        background-color: #1a1a1a;
        border: 1px solid #00ff80;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(0, 255, 128, 0.15);
    }

    th, td {
        border: 1px solid #00ff80;
        padding: 10px;
        text-align: center;
    }

    th {
        background-color: #00ff80;
        color: #0d0d0d;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    tr:hover {
        background-color: rgba(0, 255, 128, 0.1);
    }

    a {
        color: #00ff80;
        text-decoration: none;
        font-weight: bold;
    }

    a:hover {
        color: #0d0d0d;
        background-color: #00ff80;
        padding: 4px 8px;
        border-radius: 5px;
        text-shadow: 0 0 10px #00ff80;
    }

    /* === Efeito Neon nos Títulos === */
    h2 {
        text-align: left;
        border-left: 5px solid #00ff80;
        padding-left: 10px;
        margin-top: 30px;
    }
</style>

</body>
</html>
