<?php
// === Conexão com o banco de dados (MySQLi procedural) ===
require_once 'conexao.php';
if (isset($_GET['id'])) {
    // --- Modo Editar ---
    $id = $_GET['id'];

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
        /* Variáveis de Cores Neon Green */
        :root {
            --neon-green-light: #39ff14;
            /* Verde neon vibrante */
            --neon-green-dark: #00b300;
            /* Verde neon um pouco mais escuro */
            --bg-dark: #0a0a0a;
            --input-dark: #1a1a1a;
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
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            width: 90%;
            max-width: 500px;
            background-color: var(--card-bg);
            padding: 40px;
            border-radius: var(--radius);
            box-shadow: 0 0 25px rgba(57, 255, 20, 0.2);
            /* Sombra neon sutil */
            animation: fadeIn 0.5s ease-out;
        }

        h2 {
            text-align: center;
            font-size: 2.5em;
            color: var(--neon-green-light);
            margin-bottom: 30px;
            /* **MUDANÇA AQUI:** Adicionei uma margem superior para afastá-lo do topo da box */
            margin-top: 0;
            padding-top: 0;
            text-shadow: 0 0 10px var(--neon-green-light);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: var(--text-label);
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 12px;
            border: 1px solid;
            /* Borda gradiente (neon) */
            border-image: linear-gradient(to right, var(--neon-green-dark), var(--neon-green-light)) 1;
            background-color: var(--input-dark);
            color: var(--text-light);
            border-radius: var(--radius);
            font-size: 1em;
            outline: none;
            transition: all 0.3s ease;
            box-sizing: border-box;
            /* Inclui padding e border no width */
        }

        input:focus {
            /* Sombra e borda neon mais forte no foco */
            border-image: linear-gradient(to right, var(--neon-green-light), var(--neon-green-light)) 1;
            box-shadow: 0 0 15px var(--neon-shadow-medium);
        }

        button[type="submit"] {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: var(--radius);
            /* Fundo gradiente para o botão (neon) */
            background: linear-gradient(to right, var(--neon-green-dark), var(--neon-green-light));
            color: var(--bg-dark);
            /* Texto escuro no botão neon */
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            /* Sombra do botão com brilho neon */
            box-shadow: 0 4px 15px rgba(57, 255, 20, 0.4);
        }

        button[type="submit"]:hover {
            background: linear-gradient(to right, var(--neon-green-light), var(--neon-green-light));
            box-shadow: 0 6px 20px var(--neon-shadow-medium);
            transform: translateY(-2px);
        }

        /* Estilização da mensagem de retorno do PHP */
        .message {
            margin-top: 20px;
            padding: 15px;
            border-radius: var(--radius);
            text-align: center;
            font-weight: bold;
            font-size: 1.1em;
            box-shadow: 0 0 10px var(--neon-shadow-medium);
        }

        .success {
            background-color: #002a00;
            border: 1px solid var(--neon-green-light);
            color: var(--neon-green-light);
        }

        .error {
            background-color: #2a0000;
            border: 1px solid #ff3914;
            color: #ff3914;
            box-shadow: 0 0 10px rgba(255, 57, 20, 0.6);
        }

        /* Link para Dashboard */
        .dashboard-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: var(--neon-green-light);
            text-decoration: none;
            font-weight: bold;
        }

        .dashboard-link:hover {
            color: var(--neon-green-dark);
            text-decoration: underline;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <h2>Cadastro de Exercicios</h2>
    <form method="POST" action="">
        <label>Nome Exercicios</label><br>
        <input type="text" name="nome" value="<?php echo $nome ?>" required><br><br>

        <label>Series:</label><br>
        <input type="number" name="series" value="<?php echo $series ?>" required><br><br>

        <label>Repetições:</label><br>
        <input type="number" name="repeticoes" value="<?php echo $repeticoes ?>" required><br><br>

        <label>Carga:</label><br>
        <input type="number" name="carga" value="<?php echo $carga ?>" required><br><br>

        <button type="submit">Cadastrar</button>
    </form>

</body>

</html>