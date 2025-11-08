<?php
session_start();
require_once 'conexao.php';

$email = $_POST['gmail'];
$senha = $_POST['senha'];

$sql = "SELECT * FROM usuario WHERE email = ? AND senha = ?";
$comando = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($comando, 'ss', $email, $senha);

mysqli_stmt_execute($comando);

$resultados = mysqli_stmt_get_result($comando);
$quantidade = mysqli_num_rows($resultados);

if ($quantidade == 0) {
    header('Location: index.php?msg=erro');
} else {
    $usuario = mysqli_fetch_assoc($resultados);
    $nome = $usuario['nome'];
    $id = $usuario['id_usuario'];
    $senha = $usuario['senha'];
    $idade = $usuario['idade'];


    $_SESSION['nome'] = $nome;
    $_SESSION['id'] = $id;
    $_SESSION['senha'] = $senha;
    $_SESSION['idade'] = $idade; 


    header('Location: home.php');
}