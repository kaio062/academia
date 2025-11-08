<?php

    require_once "conexao.php";


if (isset($_GET['id'])) {
    // echo "editar...";

    $id = $_GET['id'];

    $sql = "SELECT * FROM tb_usuario WHERE id_usuario = ?";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'i', $id);
    mysqli_stmt_execute($comando);

    $resultados = mysqli_stmt_get_result($comando);

    $autor = mysqli_fetch_assoc($resultados);

    $nome = $_usuario['nome'];
    $email = $_usuario['email'];
    $senha = $_usuario['senha'];
    $nascimento = $usuario['data_nascimento'];
}
else {
    // echo "cadastrar...";
    
    $id = 0;
    $nome = "";
    $email = "";
    $senha = "";
    $nascimento = "";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="salvar_aluno.php?id=<?php echo $id; ?>" method="POST">
        Nome: <br>
        <input type="text" name="nome" value="<?php echo $nome;?>"> <br><br>

        Email: <br>
        <input type="text" name="email" value="<?php echo $email;?>"> <br><br>

        Senha: <br>
        <input type="text" name="senha" value="<?php echo $senha;?>"> <br><br>


        Data de nascimento: <br>
        <input type="date" name="nascimento" value="<?php echo $nascimento;?>"> <br><br>


        <input type="submit" value="Salvar">
    </form>
</body>
</html>