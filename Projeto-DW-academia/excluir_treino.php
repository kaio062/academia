<?php
require_once 'conexao.php';

$id = $_GET['id'];

$sql = "DELETE FROM treino WHERE id_treino = ?";
$comando = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($comando, 'i', $id);
$executado = mysqli_stmt_execute($comando);

if ($executado) {
    header("Location: listar_treino.php");
    exit();
} else {
    echo "<div class='message error'>❌ Erro ao excluir treino.</div>";
}
?>