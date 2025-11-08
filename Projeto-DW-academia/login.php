<?php
session_start();
include("conexao.php"); // Certifique-se de que este arquivo existe e funciona

// se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"]; 
    $senha = $_POST["senha"];

    // dados fixos do admin (poderia estar no banco também)
    $admin_usuario = "admin";
    $admin_senha = "adm12323"; // senha do administrador

    if ($usuario === $admin_usuario && $senha === $admin_senha) {
        $_SESSION["admin"] = true;
        header("Location: dashboard.php");
        exit;
    } else {
        $erro = "Usuário ou senha incorretos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema da Academia</title>
    
    <style>
        /* Variáveis de cores para facilitar a manutenção */
        :root {
            --neon-green-light: #39ff14; /* Verde neon vibrante */
            --neon-green-dark: #00b300; /* Verde neon um pouco mais escuro */
            --bg-dark: #0a0a0a;
            --input-dark: #1a1a1a;
            --text-light: #ffffff;
            --text-label: #cccccc;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-light);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            overflow: hidden;
        }

        .login-container {
            display: flex;
            width: 90%; 
            max-width: 1200px; 
            background-color: var(--bg-dark);
            border-radius: 10px; 
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.7); 
        }

        .login-form-section {
            flex: 1;
            padding: 60px; 
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            position: relative;
            z-index: 2; 
        }

        .login-form-section h1 {
            font-size: 3em; 
            margin-bottom: 40px;
            color: var(--text-light);
            font-weight: bold;
            letter-spacing: 1px;
        }

        .login-form-section h1 span {
            color: var(--neon-green-light); /* Ponto neon */
        }

        .form-group {
            margin-bottom: 25px;
            width: 100%;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-size: 1em;
            color: var(--text-label);
        }

        .form-group input {
            width: calc(100% - 20px); 
            padding: 15px;
            border: 1px solid;
            /* Borda gradiente (neon) */
            border-image: linear-gradient(to right, var(--neon-green-dark), var(--neon-green-light)) 1; 
            background-color: var(--input-dark); 
            color: var(--text-light);
            border-radius: 8px;
            font-size: 1em;
            outline: none;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            /* Sombra e borda neon mais forte no foco */
            border-image: linear-gradient(to right, var(--neon-green-light), var(--neon-green-light)) 1; 
            box-shadow: 0 0 15px rgba(57, 255, 20, 0.6);
        }

        .forgot-password {
            display: block;
            text-align: left;
            margin-top: -10px; 
            margin-bottom: 30px;
            font-size: 0.9em;
            color: var(--neon-green-light);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .forgot-password:hover {
            color: var(--neon-green-dark);
        }

        .login-button {
            width: 100%;
            padding: 18px;
            border: none;
            border-radius: 8px;
            /* Fundo gradiente para o botão (neon) */
            background: linear-gradient(to right, var(--neon-green-dark), var(--neon-green-light));
            color: var(--bg-dark); /* Texto escuro no botão neon */
            font-size: 1.2em;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            /* Sombra do botão com brilho neon */
            box-shadow: 0 4px 15px rgba(57, 255, 20, 0.4);
        }

        .login-button:hover {
            background: linear-gradient(to right, var(--neon-green-light), var(--neon-green-light));
            box-shadow: 0 6px 20px rgba(57, 255, 20, 0.6);
            transform: translateY(-2px);
        }

        .signup-link {
            display: block;
            text-align: left;
            margin-top: 30px;
            font-size: 0.95em;
            color: var(--text-label);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .signup-link a {
            color: var(--neon-green-light);
            text-decoration: none;
        }

        .signup-link a:hover {
            color: var(--neon-green-dark);
        }

        .image-section {
            flex: 1;
            /* ATUALIZADO: Usando o nome do arquivo que você gerou */
            background-image: url('Gemini_Generated_Image_s7ebugs7ebugs7eb.png'); 
            background-size: cover;
            background-position: center;
            border-radius: 0 10px 10px 0; 
            position: relative;
            overflow: hidden;
        }

        .image-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            /* Gradiente de opacidade ajustado para o tema escuro */
            background: linear-gradient(to right, rgba(10, 10, 10, 0.9), rgba(10, 10, 10, 0.2)); 
            z-index: 1;
        }

        .footer {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 0.85em;
            color: #777777;
            white-space: nowrap; 
            z-index: 10; 
        }

        .footer a {
            color: var(--neon-green-light);
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .erro {
            color: var(--neon-green-light); /* Cor de erro em neon */
            text-align: center;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #002a00; /* Fundo de erro sutilmente verde-escuro */
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(57, 255, 20, 0.5); /* Brilho neon no erro */
        }
        
        /* Ajustes Responsivos */
        @media (max-width: 900px) {
            .login-container {
                flex-direction: column;
                width: 100%;
                max-width: 500px;
            }

            .image-section {
                display: none; 
            }

            .login-form-section {
                padding: 40px;
                align-items: center;
                text-align: center;
            }

            .login-form-section h1 {
                font-size: 2.5em;
                margin-bottom: 30px;
            }

            .forgot-password,
            .signup-link {
                text-align: center;
            }

            .footer {
                position: static; 
                transform: none;
                margin-top: 30px;
                text-align: center;
            }
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-form-section">
        <h1>Faça seu Login!<span></span></h1>

        <?php if (isset($erro)) echo "<p class='erro'>$erro</p>"; ?>

        <form method="POST" style="width: 100%;">
            <div class="form-group">
                <label for="usuario">Usuário</label>
                <input type="text" id="usuario" name="usuario" placeholder="Seu usuário/email" required>
            </div>

            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" placeholder="Sua senha" required>
            </div>

            <button type="submit" class="login-button">Entrar</button>
            
        </form>
    </div>

    <div class="image-section">
        </div>
</div>

</body>
</html>