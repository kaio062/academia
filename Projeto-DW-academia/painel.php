<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}
require 'config.php';

// Consultas rápidas
$totalAlunos = $pdo->query("SELECT COUNT(*) FROM alunos")->fetchColumn();
$totalNovatos = $pdo->query("SELECT COUNT(*) FROM alunos WHERE privilegio='novato'")->fetchColumn();
$totalVeteranos = $pdo->query("SELECT COUNT(*) FROM alunos WHERE privilegio='veterano'")->fetchColumn();
$totalExercicios = $pdo->query("SELECT COUNT(*) FROM exercicios")->fetchColumn();
$totalTreinos = $pdo->query("SELECT COUNT(*) FROM treinos")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head><meta charset="UTF-8"><title>Painel Admin</title></head>
<body>
<h1>Painel do Administrador</h1>
<hr>
<h2>Informações Gerais</h2>
<ul>
    <li>Total de Alunos: <?= $totalAlunos ?></li>
    <li>Novatos: <?= $totalNovatos ?></li>
    <li>Veteranos: <?= $totalVeteranos ?></li>
    <li>Total de Exercícios: <?= $totalExercicios ?></li>
    <li>Total de Treinos: <?= $totalTreinos ?></li>
</ul>
<hr>
<h2>Gerenciamento</h2>
<ul>
    <li><a href="cadastro_exercicio.php">Cadastrar Exercício</a></li>
    <li><a href="cadastro_aluno.php">Cadastrar Aluno</a></li>
    <li><a href="atribuir_privilegios.php">Gerenciar Privilégios</a></li>
</ul>
<a href="logout.php">Sair</a>
</body>
</html>






