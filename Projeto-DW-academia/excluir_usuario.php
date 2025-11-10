<?php
require_once 'conexao.php';

$id = $_GET['id'];

// Exclui históricos do usuário
$sqlHistorico = "DELETE FROM historico_treino WHERE usuario_id = ?";
$cmdHistorico = mysqli_prepare($conexao, $sqlHistorico);
mysqli_stmt_bind_param($cmdHistorico, 'i', $id);
mysqli_stmt_execute($cmdHistorico);

// Exclui treinos vinculados ao usuário (opcional, se necessário)
$sqlTreino = "DELETE FROM usuario_treino WHERE usuario_id_usuario = ?";
$cmdTreino = mysqli_prepare($conexao, $sqlTreino);
mysqli_stmt_bind_param($cmdTreino, 'i', $id);
mysqli_stmt_execute($cmdTreino);

// Agora exclui o usuário
$sql = "DELETE FROM usuario WHERE id_usuario = ?";
$comando = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($comando, 'i', $id);
$executado = mysqli_stmt_execute($comando);

if ($executado) {
    header("Location: listar_usuario.php");
    exit();
} else {
    echo "<div class='message error'>❌ Erro ao excluir usuário.</div>";
}
