<?php
// === Conexão com o banco de dados (MySQLi procedural) ===
require_once 'conexao.php';
if (isset($_GET['id'])) {
    // --- Modo Editar ---
    $id = $_GET['id']; // 2

    require_once "conexao.php";

    $sql = "SELECT * FROM treino WHERE id_treino = ?";
    $comando = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($comando, 'i', $id);
    mysqli_stmt_execute($comando);
    $resultados = mysqli_stmt_get_result($comando);

    $treino = mysqli_fetch_assoc($resultados);

    $nome = $treino['nome_treino'];
    $descricao = $treino['descricao'];
    
    // var_dump($descricao);
} else {
    // --- Modo Cadastrar ---
    $id = 0;
    $nome = "";
    $descricao = "";

}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST["nome_treino"];
    $descricao = $_POST["descricao"];
   

    if ($id == 0) {
        // Inserir novo
        $sql = "INSERT INTO treino (nome_treino, descricao) VALUES (?, ?)";
        $comando = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param($comando, "ss", $nome, $descricao);
        $executado = mysqli_stmt_execute($comando);

        if ($executado) {
            $mensagem = "<div class='message success'>✅ Treino cadastrado com sucesso!</div>";
            header("Location: listar_treino.php");
        } else {
            $mensagem = "<div class='message error'>❌ Erro ao cadastrar treino.</div>";
        }
    } else {
        // Atualizar existente
        $sql = "UPDATE treino SET nome_treino = ?, descricao = ? WHERE id_treino = ?";
        $comando = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param($comando, "ssi", $nome, $descricao, $id);
        $executado = mysqli_stmt_execute($comando);

        if ($executado) {
            $mensagem = "<div class='message success'>✅ Treino atualizado com sucesso!</div>";
            header("Location: listar_treino.php");
        } else {
            $mensagem = "<div class='message error'>❌ Erro ao atualizar treino.</div>";
        }
    }
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

    </style>
</head>
<body>
    <form method="POST" action="">
        <h2>Cadastrar Treino</h2>

        <label for="nome_treino">Nome do Treino:</label>
        <input type="text" name="nome_treino" value="<?php echo $nome?>" id="nome_treino" required>

        <label for="descricao">Descrição:</label>
        <input type="text" name="descricao" value="<?php echo $descricao?>" id="descricao" required>

        <button type="submit" name="cadastrar">Cadastrar</button>
        <button><a href="dashboard.php">Voltar</a></button>
    </form>

    <li><a href="dashboard.php"><span></span>


</body>
</html>
