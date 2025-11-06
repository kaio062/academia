<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form action="verificar_login.php" method="post">
        <label>Email:</label><br>
        <input type="text" name="gmail" required><br><br>

        <label>Senha:</label><br>
        <input type="password" name="senha" required><br><br>

        <input type="submit" value="Entrar">
    </form>

    <p><a href="cadastro.php">Cadastrar novo usuário</a></p>

    <?php
    if (isset($_GET['msg']) && $_GET['msg'] === 'erro') {
        echo "<p style='color:red;'>Erro de usuário ou senha</p>";
    }
    ?>
</body>
</html>
