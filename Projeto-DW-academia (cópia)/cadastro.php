<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
</head>
<body>
    <h2>Cadastro</h2>

    <form method="POST" action="cadastra_usuario.php">
        <label>Usuário:</label><br>
        <input type="text" name="usuario" required><br><br>

        <label>Senha:</label><br>
        <input type="password" name="senha" required><br><br>

        <label>Email:</label><br>
        <input type="text" name="email" required><br><br>

        <label>Data de Nascimento:</label><br>
        <input type="date" name="data_nascimento" required><br><br>

        <input type="submit" value="Cadastrar">
    </form>

    <p><a href="login.php">Voltar para o login</a></p>

    <?php
    if (isset($_GET['erro'])) {
        echo "<p style='color:red;'>Usuário já existe!</p>";
    }
    if (isset($_GET['ok'])) {
        echo "<p style='color:green;'>Usuário cadastrado com sucesso!</p>";
    }
    ?>
</body>
</html>
<!-- parte feita pelo max -->