<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Cadastro de Treino</h1>
    <form action="salvar_treino.php" method="post" enctype="multipart form-data">

        <label for="nome">Nome do Treino:</label>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="descricao">Descrição:</label><br>
        <textarea id="descricao" name="descricao" rows="4" cols="50" required></textarea><br><br>
 
        

        <input type="submit" value="Salvar Treino">

    </form> 
</body>
</html>
