<?php
// === Conexão com o banco de dados (MySQLi procedural) ===
require_once 'conexao.php';
if (isset($_GET['id'])) {
    // --- Modo Editar ---
    $id = $_GET['id']; // 2

    require_once "conexao.php";

    $sql = "SELECT * FROM usuario WHERE id_usuario = ?";
    $comando = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($comando, 'i', $id);
    mysqli_stmt_execute($comando);
    $resultados = mysqli_stmt_get_result($comando);

    $usuario = mysqli_fetch_assoc($resultados);

    $nome = $usuario['nome'];
    $email = $usuario['email'];
    $senha = $usuario['senha'];
    $idade = $usuario['idade'];
} else {
    // --- Modo Cadastrar ---
    $id = 0;
    $nome = "";
    $email = "";
    $senha = "";
    $idade = "";
}


// === Cadastrar ou atualizar usuarios ===
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $idade = $_POST["idade"];



    if ($id == 0) {
        // === Calcula a idade a partir da data de nascimento ===
        $hoje = new DateTime(); // data atual
        $nascimento = new DateTime($idade);
        $idade = $nascimento->diff($hoje)->y; // diferença em anos
        // === Define o tipo de aluno automaticamente ===
        if ($idade < 25) {
            $tipo = "Novato";
            $treino_id = 1; // Treino para iniciantes
        } else {
            $tipo = "Veterano";
            $treino_id = 2; // Treino para experientes
        }

        // Inserir novo
        $sql = "INSERT INTO usuario (nome, email, senha, idade) VALUES (?, ?, ?, ?)";
        $comando = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param($comando, "sssi", $nome, $email, $senha, $idade);
        $executado = mysqli_stmt_execute($comando);

        if ($executado) {
            $mensagem = "<div class='message success'>✅ Usuario cadastrado com sucesso!</div>";
            header("Location: listar_usuario.php");
        } else {
            $mensagem = "<div class='message error'>❌ Erro ao cadastrar Usuario.</div>";
        }
    } else {
        // Atualizar existente
        $sql = "UPDATE usuario SET nome = ?, email = ?, senha = ?, idade = ? WHERE id_usuario = ?";
        $comando = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param($comando, "sssii", $nome, $email, $senha, $idade, $id);
        $executado = mysqli_stmt_execute($comando);

        if ($executado) {
            $mensagem = "<div class='message success'>✅ Usuario atualizado com sucesso!</div>";
            header("Location: listar_usuario.php");
        } else {
            $mensagem = "<div class='message error'>❌ Erro ao atualizar usuario.</div>";
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
input, select, textarea {
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
input:focus, select:focus, textarea:focus {
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
a{
    text-decoration: none;
}

    </style>
</head>

<body>
    <form method="POST" action="">
        <h2>Cadastro de Usuario</h2>
        <label>Nome Usuario</label><br>
        <input type="text" name="nome" value="<?php echo $nome ?>" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="<?php echo $email ?>" required><br><br>

        <label>senha:</label><br>
        <input type="password" name="senha" value="<?php echo $senha ?>" onclick="this.type = this.type === 'password' ? 'text' : 'password'" required><br><br>

        <label>Idade:</label><br>
        <?php
        if ($idade === "") {
            echo '
            <input type="date" name="idade" value="<?php echo $idade ?>"required><br><br>';
        } else {
            echo '<input type="number" name="idade" value="' . htmlspecialchars($idade) . '" required><br><br>';
        }
        ?>

        <button type="submit">Cadastrar</button>
        <button><a href="dashboard.php">Voltar</a></button>

    </form>

</body>

</html>