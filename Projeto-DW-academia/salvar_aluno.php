<?php
    require_once "conexao.php";
    
    // pega as valores lá do formulário
    $id = $_GET['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $nascimento = $_POST['data_nascimento'];

    if ($id == 0) {
        //novo
        $sql = "INSERT INTO tb_usuario (id_usuario, nome, email, senha, data_nascimento) VALUES (?, ?, ?, ?, ?)";

        $comando = mysqli_prepare($conexao, $sql);
        
        mysqli_stmt_bind_param($comando, 'ssss', $nome, $email, $senha, $nascimento);
    }
    else {
        //editar
        $sql = "UPDATE tb_usuario SET nome = ?, email = ?, senha = ?, data_nascimento = ? WHERE id_usuario = ?";
        
        $comando = mysqli_prepare($conexao, $sql);

        mysqli_stmt_bind_param($comando, 'sssi', $nome, $email, $senha, $nascimento, $id);

    }

    mysqli_stmt_execute($comando);

    mysqli_stmt_close($comando);

    header("Location: index.php");
?>
