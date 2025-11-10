<?php
// === Conexão com o banco de dados (MySQLi procedural) ===
require_once 'conexao.php';
if (isset($_GET['id'])) {
    // --- Modo Editar ---
    $id = $_GET['id']; // 2

    require_once "conexao.php";

    $sql = "SELECT * FROM exercicio WHERE id_exercicio = ?";
    $comando = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($comando, 'i', $id);
    mysqli_stmt_execute($comando);
    $resultados = mysqli_stmt_get_result($comando);

    $exercicio = mysqli_fetch_assoc($resultados);

    $nome = $exercicio['nome_exercicio'];
    $series = $exercicio['series'];
    $repeticoes = $exercicio['repeticoes'];
    $carga = $exercicio['carga'];
} else {
    // --- Modo Cadastrar ---
    $id = 0;
    $nome = "";
    $series = "";
    $repeticoes = "";
    $carga = "";
}


// === Cadastrar ou atualizar exercício ===
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST["nome"];
    $series = $_POST["series"];
    $repeticoes = $_POST["repeticoes"];
    $carga = $_POST["carga"];

    if ($id == 0) {
        // Inserir novo
        $sql = "INSERT INTO exercicio (nome_exercicio, series, repeticoes, carga) VALUES (?, ?, ?, ?)";
        $comando = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param($comando, "siid", $nome, $series, $repeticoes, $carga);
        $executado = mysqli_stmt_execute($comando);

        if ($executado) {
            $mensagem = "<div class='message success'>✅ Exercício cadastrado com sucesso!</div>";
            header("Location: listar_exercicios.php");
        } else {
            $mensagem = "<div class='message error'>❌ Erro ao cadastrar exercício.</div>";
        }
    } else {
        // Atualizar existente
        $sql = "UPDATE exercicio SET nome_exercicio = ?, series = ?, repeticoes = ?, carga = ? WHERE id_exercicio = ?";
        $comando = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param($comando, "siidi", $nome, $series, $repeticoes, $carga, $id);
        $executado = mysqli_stmt_execute($comando);

        if ($executado) {
            $mensagem = "<div class='message success'>✅ Exercício atualizado com sucesso!</div>";
            header("Location: listar_exercicios.php");
        } else {
            $mensagem = "<div class='message error'>❌ Erro ao atualizar exercício.</div>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Cadastro de Aluno</title>
    <style>
        /* === Tema Neon Academia - Exercício === */
        body {
            font-family: Arial, sans-serif;
            background-color: #111;
            color: #0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Caixa principal */
        form {
            background-color: #222;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px #0f0;
            width: 400px;
            text-align: center;
        }

        /* Título */
        form h2 {
            margin-bottom: 20px;
            text-shadow: 0 0 10px #0f0;
        }

        /* Campos de entrada */
        input,
        select,
        textarea {
            display: block;
            width: 100%;
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #0f0;
            border-radius: 6px;
            background-color: #111;
            color: #0f0;
            font-size: 15px;
            outline: none;
            transition: 0.2s ease;
        }

        /* Efeito ao focar */
        input:focus,
        select:focus,
        textarea:focus {
            box-shadow: 0 0 8px #0f0;
        }

        /* Textarea */
        textarea {
            resize: none;
            height: 80px;
        }

        /* Botões principais */
        button {
            background-color: #0f0;
            color: #111;
            font-weight: bold;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s;
            margin-top: 10px;
        }

        button:hover {
            background-color: #09c409;
            transform: scale(1.05);
        }

        /* Link dentro dos botões */
        button a {
            text-decoration: none;
            color: #111;
            display: block;
        }

        /* Botão “Voltar” estilizado */
        button.voltar {
            background-color: transparent;
            border: 1px solid #0f0;
            color: #0f0;
        }

        button.voltar:hover {
            background-color: #0f0;
            color: #111;
        }

        /* Mensagens de sucesso/erro */
        .message {
            margin-top: 15px;
            padding: 10px;
            border-radius: 6px;
            font-weight: bold;
        }

        .message.success {
            color: #0f0;
            border: 1px solid #0f0;
        }

        .message.error {
            color: #f00;
            border: 1px solid #f00;
        }

        a {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <form method="POST" action="">
        <h2>Cadastro de Exercicios</h2>
        <label>Nome Exercicios</label><br>
        <input type="text" name="nome" value="<?php echo $nome ?>" required><br><br>

        <label>Series:</label><br>
        <input placeholder="Insira no max. 2 números" type="number" name="series" value="<?php echo $series ?>" required><br><br>

        <label>Repetições:</label><br>
        <input placeholder="Insira no max. 2 números" type="number" name="repeticoes" value="<?php echo $repeticoes ?>" required><br><br>

        <label>Carga:</label><br>
        <input type="number" name="carga" value="<?php echo $carga ?>" required><br><br>

        <button type="submit">Cadastrar</button>
        <button><a href="dashboard.php">Voltar</a></button>
    </form>


</body>

</html>