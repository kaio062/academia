<?php

require_once 'conexao.php';
session_start();

$email= $_POST['gmail'];
$senha = $_POST['senha'];
// var_dump($email, values: $senha);
$sql = "SELECT * FROM usuario WHERE email = ? AND senha = ?";
$comando = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($comando, 'ss', $email, $senha);
mysqli_stmt_execute($comando);
$resultado = mysqli_stmt_get_result($comando);
if (mysqli_num_rows($resultado) == 1) {
    $usuario = mysqli_fetch_assoc($resultado);
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['usuario_nome'] = $usuario['nome'];
    header("Location: dashboard.php");
} else {
    header("Location: index.php?msg=erro");
}