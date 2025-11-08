<?php
require_once "conexao.php"; // Conexão com o banco

// Se o formulário foi enviado
if (isset($_POST["cadastrar"])) {
    // Captura e limpa os dados do formulário
    $nome_treino = trim($_POST["nome_treino"]);
    $descricao = trim($_POST["descricao"]);

    // Verifica se todos os campos foram preenchidos
    if (empty($nome_treino) || empty($descricao)) {
        echo "<script>alert('Preencha todos os campos!'); history.back();</script>";
        exit;
    }

    // Prepara o SQL
    $sql = "INSERT INTO treino (nome_treino, descricao) VALUES (?, ?)";
    $comando = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($comando, "ss", $nome_treino, $descricao);

    // Executa
    if (mysqli_stmt_execute($comando)) {
        echo "<script>
                alert('Treino cadastrado com sucesso!');
                window.location.href = 'listar_treinos.php';
              </script>";
    } else {
        echo "<script>
                alert('Erro ao cadastrar o treino.');
                history.back();
              </script>";
    }

    mysqli_stmt_close($comando);
    mysqli_close($conexao);
}
?>

<!-- ======== Formulário HTML ======== -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Treino</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #111;
            color: #0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            background-color: #222;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 0 15px #0f0;
            width: 350px;
        }
        input, textarea {
            display: block;
            width: 100%;
            margin: 10px 0;
            padding: 8px;
            border: 1px solid #0f0;
            border-radius: 6px;
            background-color: #111;
            color: #0f0;
        }
        textarea {
            resize: none;
            height: 80px;
        }
        button {
            background-color: #0f0;
            color: #111;
            font-weight: bold;
            border: none;
            padding: 10px 15px;
            border-radius: 6px;
            cursor: pointer;
        }
        button:hover {
            background-color: #09c409;
        }
    </style>
</head>
<body>
    <form method="POST" action="">
        <h2>Cadastrar Treino</h2>

        <label for="nome_treino">Nome do Treino:</label>
        <input type="text" name="nome_treino" id="nome_treino" required>

        <label for="descricao">Descrição:</label>
        <textarea name="descricao" id="descricao" required></textarea>

        <button type="submit" name="cadastrar">Cadastrar</button>
    </form>
</body>
</html>
