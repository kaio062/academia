<?php
$usuario = $_POST['usuario'] ?? '';
$senha = $_POST['senha'] ?? '';

include 'usuarios.php';

if (isset($usuarios[$usuario])) {
    header('Location: cadastro.php?erro=1');
    exit;
}


header('Location: cadastro.php?ok=1');
exit;
?>
