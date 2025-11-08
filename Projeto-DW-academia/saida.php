<?php 
require_once "conexao.php"; 

$gmail = $_POST['gmail'];

$senha = $_POST['senha'];

var_dump($gmail, $senha);

$sql = "select * FROM usuario where email = ? ";
$comando = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($comando, 's', $gmail);
mysqli_execute($comando);
$resultado = mysqli_stmt_get_result($comando);
$usuario = mysqli_fetch_assoc($resultado);
