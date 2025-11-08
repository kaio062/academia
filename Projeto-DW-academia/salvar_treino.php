<?php

require_once "conexao.php";
    
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];

     
    $sql = "INSERT INTO treino (nome, descricao) VALUES (?, ?)";
    $comando = mysqli_prepare($conexao, $sql);

    // letra s -> varchar, date, datetime, char
    // letra i -> int
    // letra d -> float, decimal
    mysqli_stmt_bind_param($comando, 'ss', $nome_treino, $descricao);

    mysqli_stmt_execute($comando);

    mysqli_stmt_close($comando);

    header("Location: treino_cadastro.php");

   
?>
 //feito por Heitor