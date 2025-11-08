<?php
session_start();
include 'usuarios.php';

$usuario = $_POST['usuario'] ?? '';
$senha = $_POST['senha'] ?? '';

if (isset($usuarios[$usuario]) && $usuarios[$usuario] === $senha) {
    $_SESSION['usuario'] = $usuario;
    header('Location: index.php');
    exit;
} else {
    header('Location: login.php?erro=1');
    exit;
}
?>
