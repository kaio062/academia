<?php
session_start();
require_once 'conexao.php';

// --- BLOCO DE CONSULTAS (igual ao seu código) ---
if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit;
}

// === 1. Total de usuários ===
$sql = "SELECT COUNT(*) AS total_usuarios FROM usuario;";
$comando = mysqli_prepare($conexao, $sql);
mysqli_stmt_execute($comando);
$resultado = mysqli_stmt_get_result($comando);
$usuario = mysqli_fetch_assoc($resultado);

// === 2. Total de treinos ===
$sqlTreino = "SELECT COUNT(*) AS total_treinos FROM treino;";
$comandoTreino = mysqli_prepare($conexao, $sqlTreino);
mysqli_stmt_execute($comandoTreino);
$resultadoTreino = mysqli_stmt_get_result($comandoTreino);
$usuarioTreino = mysqli_fetch_assoc($resultadoTreino);

// === 3. Total de exercícios ===
$sqlExercicios = "SELECT COUNT(*) AS total_exercicios FROM exercicio;";
$comandoExercicio = mysqli_prepare($conexao, $sqlExercicios);
mysqli_stmt_execute($comandoExercicio);
$resultadoExercicio = mysqli_stmt_get_result($comandoExercicio);
$usuarioExercicio = mysqli_fetch_assoc($resultadoExercicio);

// === 4. Total de treinos realizados ===
$sqlTreinosRealizados = "SELECT COUNT(*) AS total_treinos_realizados FROM historico_treino;";
$comandoTreinosRealizados = mysqli_prepare($conexao, $sqlTreinosRealizados);
mysqli_stmt_execute($comandoTreinosRealizados);
$resultadoTreinosRealizados = mysqli_stmt_get_result($comandoTreinosRealizados);
$usuarioTreinosRealizados = mysqli_fetch_assoc($resultadoTreinosRealizados);

// === 5. Usuários e seus treinos ===
$sqlusuario = "
    SELECT 
        u.id_usuario, 
        u.nome AS nome_usuario, 
        t.nome_treino 
    FROM usuario u
    JOIN usuario_treino AS ut ON u.id_usuario = ut.usuario_id_usuario
    JOIN treino AS t ON t.id_treino = ut.treino_id_treino
    ORDER BY u.nome;
";
$comandousuario = mysqli_prepare($conexao, $sqlusuario);
mysqli_stmt_execute($comandousuario);
$resultadousuario = mysqli_stmt_get_result($comandousuario);

// === 6. Treinos e exercícios ===
$sqltrn = "
    SELECT 
        t.nome_treino, 
        e.nome_exercicio, 
        e.series, 
        e.repeticoes, 
        e.carga 
    FROM treino AS t 
    JOIN exercicio_treino AS et ON t.id_treino = et.treino_id 
    JOIN exercicio AS e ON e.id_exercicio = et.exercicio_id
    ORDER BY t.nome_treino;
";
$comandotrn = mysqli_prepare($conexao, $sqltrn);
mysqli_stmt_execute($comandotrn);
$resultadotrn = mysqli_stmt_get_result($comandotrn);

// === 7. Histórico de treinos ===
$sqlhistorico = "
    SELECT 
        h.id_historico, 
        u.nome AS usuario, 
        t.nome_treino, 
        h.data_treino, 
        h.duracao_minutos, 
        h.observacoes 
    FROM historico_treino AS h 
    JOIN usuario AS u ON h.usuario_id = u.id_usuario 
    JOIN treino AS t ON h.treino_id = t.id_treino 
    ORDER BY h.data_treino DESC 
    LIMIT 10;
";
$comandohistorico = mysqli_prepare($conexao, $sqlhistorico);
mysqli_stmt_execute($comandohistorico);
$resultadohistorico = mysqli_stmt_get_result($comandohistorico);

// === 8. Treino mais realizado ===
$sqlnmtreino = "
    SELECT 
        t.nome_treino, 
        COUNT(h.treino_id) AS vezes_realizado 
    FROM historico_treino AS h 
    JOIN treino AS t ON t.id_treino = h.treino_id 
    GROUP BY t.id_treino 
    ORDER BY vezes_realizado DESC 
    LIMIT 1;
";
$comandonmtreino = mysqli_prepare($conexao, $sqlnmtreino);
mysqli_stmt_execute($comandonmtreino);
$resultadonmtreino = mysqli_stmt_get_result($comandonmtreino);
$usuarionmtreino = mysqli_fetch_assoc($resultadonmtreino);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Dashboard - Painel do Administrador</title>
    <style>
        /* === Estilo Base === */
        :root {
            --bg-color: #0a0a0a;
            --primary-color: #39ff14;
            --primary-light: #0aff9d;
            --text-color: #e5e5e5;
            --text-secondary: #8a8a8a;
            --card-bg: #111111;
            --card-shadow: rgba(0, 255, 136, 0.15);
            --radius: 14px;
        }

        body {
            font-family: 'Poppins', 'Segoe UI', Arial, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        .container {
            width: 92%;
            max-width: 1200px;
            margin: 40px auto;
        }

        /* === Cabeçalho === */
        .dashboard-header {
            text-align: center;
            margin-bottom: 40px;
            animation: fadeInDown 0.6s ease;
        }

        .dashboard-header h1 {
            margin: 0;
            font-size: 2.2em;
            font-weight: 700;
            color: var(--primary-color);
            letter-spacing: -0.5px;
            text-shadow: 0 0 10px var(--primary-color);
        }

        .dashboard-header p {
            color: var(--text-secondary);
            margin-top: 10px;
            font-size: 1em;
        }



        /* === Cards === */
        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 40px;
            justify-content: center;
        }

        .card {
            background: var(--card-bg);
            border-radius: var(--radius);
            box-shadow: 0 4px 20px var(--card-shadow);
            padding: 25px;
            flex: 1;
            min-width: 230px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0 20px rgba(0, 255, 136, 0.2);
        }

        .card h5 {
            color: var(--text-secondary);
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 0.95em;
        }

        .card h2 {
            color: var(--primary-color);
            font-size: 2em;
            font-weight: 700;
            margin: 0;
            text-shadow: 0 0 10px var(--primary-color);
        }

        /* === Alert === */
        .alert {
            background: rgba(0, 255, 136, 0.1);
            border-left: 5px solid var(--primary-color);
            color: var(--primary-color);
            padding: 18px;
            text-align: center;
            border-radius: var(--radius);
            margin-bottom: 40px;
            font-weight: 500;
            box-shadow: 0 0 10px rgba(0, 255, 136, 0.15);
            animation: fadeIn 0.8s ease;
        }

        /* === Tabelas === */
        .card-header {
            background: linear-gradient(90deg, #003321, #00ff88);
            color: white;
            padding: 14px;
            border-radius: var(--radius) var(--radius) 0 0;
            font-weight: 600;
            text-align: left;
            letter-spacing: 0.3px;
            text-shadow: 0 0 8px var(--primary-color);
        }

        .card-body {
            background: var(--card-bg);
            border-radius: 0 0 var(--radius) var(--radius);
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 0.95em;
        }

        table th,
        table td {
            padding: 12px 10px;
            border-bottom: 1px solid #1a1a1a;
            text-align: center;
        }

        table th {
            background-color: #0f0f0f;
            color: var(--primary-color);
            text-transform: uppercase;
            font-size: 0.85em;
            letter-spacing: 0.5px;
        }

        table tr:hover {
            background-color: rgba(0, 255, 136, 0.05);
            transition: 0.2s;
        }

        /* === Animações === */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* === Responsivo === */
        @media (max-width: 768px) {
            .sidebar {
                width: 80px;
            }

            .sidebar.collapsed {
                width: 0;
            }

            .container {
                margin-left: 90px;
            }

            .row {
                flex-direction: column;
                align-items: center;
            }

            .card {
                width: 100%;
                max-width: 350px;
            }

            .dashboard-header h1 {
                font-size: 1.8em;
            }
        }
    </style>


<body>

    <div class="container">
        <nav class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <span class="logo">🏋️</span>
                <span class="titulo">Academia</span>
            </div>

            <ul class="menu">
                <li><a href="dashboard.php"><span>🏠</span>
                        <p>Dashboard</p>
                    </a></li>
                <li><a href="logout.php"><span>🚪</span>
                        <p>Sair</p>
                    </a></li>

                <hr>
                <h4>🏋️ Treino</h4>
                <li><a href="treino.php"><span>➕</span>
                        <p>Cadastrar</p>
                    </a></li>
                <li><a href="listar_treino.php"><span>📋</span>
                        <p>Listar</p>
                    </a></li>

                <hr>
                <h4>💪 Exercício</h4>
                <li><a href="exercicio.php"><span>➕</span>
                        <p>Cadastrar</p>
                    </a></li>
                <li><a href="listar_exercicios.php"><span>📋</span>
                        <p>Listar</p>
                    </a></li>

                <hr>
                <h4>👤 Usuário</h4>
                <li><a href="usuario.php"><span>➕</span>
                        <p>Cadastrar</p>
                    </a></li>
                <li><a href="listar_usuario.php"><span>📋</span>
                        <p>Listar</p>
                    </a></li>
            </ul>

            <button class="toggle-btn" id="toggleSidebar" title="Expandir/Recolher menu">☰</button>
        </nav>

        <script>
            const toggle = document.getElementById('toggleSidebar');
            const sidebar = document.getElementById('sidebar');
            const titleTexts = sidebar.querySelectorAll('.menu p, .sidebar-header .titulo, .menu h4');

            toggle.addEventListener('click', () => {
                sidebar.classList.toggle('collapsed');
                // Faz animação suave sumindo/aparecendo o texto
                titleTexts.forEach(el => {
                    if (sidebar.classList.contains('collapsed')) {
                        el.style.opacity = "0";
                        setTimeout(() => el.style.display = "none", 200);
                    } else {
                        el.style.display = "block";
                        setTimeout(() => el.style.opacity = "1", 50);
                    }
                });
            });
        </script>

        <style>
            :root {
                --bg-color: #0f0f0f;
                --primary-color: #00ff80;
                --primary-light: #00ffaa;
                --text-color: #e0e0e0;
            }

            /* === MENU LATERAL === */
            .sidebar {
                width: 240px;
                background: var(--bg-color);
                box-shadow: 2px 0 15px rgba(0, 255, 136, 0.15);
                position: fixed;
                left: 0;
                top: 0;
                bottom: 0;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                transition: width 0.3s ease;
                overflow: hidden;
                z-index: 100;
            }

            .sidebar.collapsed {
                width: 80px;
            }

            .sidebar-header {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
                padding: 20px;
                color: var(--primary-color);
                font-weight: bold;
                font-size: 1.3em;
                text-shadow: 0 0 10px var(--primary-color);
                white-space: nowrap;
            }

            .menu {
                list-style: none;
                padding: 0;
                margin: 0;
                flex: 1;
            }

            .menu li {
                margin: 6px 0;
            }

            .menu a {
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 10px 20px;
                text-decoration: none;
                color: var(--text-color);
                border-radius: 8px;
                transition: all 0.3s ease;
            }

            .menu a:hover {
                background: rgba(0, 255, 136, 0.1);
                color: var(--primary-color);
                box-shadow: 0 0 8px rgba(0, 255, 136, 0.3);
                transform: translateX(4px);
            }

            .menu span {
                font-size: 1.2em;
            }

            .menu p {
                margin: 0;
                font-weight: 500;
                transition: opacity 0.3s ease;
            }

            .menu h4 {
                color: var(--primary-color);
                text-align: center;
                margin: 10px 0;
                font-size: 0.9em;
                text-shadow: 0 0 5px var(--primary-light);
                transition: opacity 0.3s ease;
            }

            hr {
                border: none;
                height: 1px;
                background: rgba(0, 255, 136, 0.2);
                margin: 10px 15px;
            }

            /* === Botão de colapsar === */
            .toggle-btn {
                background: var(--primary-color);
                color: #000;
                border: none;
                cursor: pointer;
                padding: 12px 0;
                font-size: 1.3em;
                font-weight: bold;
                transition: all 0.3s ease;
            }

            .toggle-btn:hover {
                background: var(--primary-light);
                box-shadow: 0 0 10px var(--primary-color);
            }

            /* === Layout principal === */
            .container {
                margin-left: 260px;
                padding: 20px;
                transition: margin-left 0.3s ease;
            }

            .sidebar.collapsed+.container {
                margin-left: 100px;
            }
        </style>



        <div class="dashboard-header">
            <h1>BEATSMODE</h1>
            <p>Bem-vindo ao painel de controle da academia 💪</p>
        </div>

        <!-- === Cards de estatísticas === -->
        <div class="row">
            <div class="card">
                <h5>Total de Usuários</h5>
                <h2><?php echo $usuario['total_usuarios'] ?></h2>
            </div>
            <div class="card">
                <h5>Total de Treinos</h5>
                <h2><?php echo $usuarioTreino['total_treinos'] ?></h2>
            </div>
            <div class="card">
                <h5>Total de Exercícios</h5>
                <h2><?php echo $usuarioExercicio['total_exercicios'] ?></h2>
            </div>
            <div class="card">
                <h5>Treinos Realizados</h5>
                <h2><?php echo $usuarioTreinosRealizados['total_treinos_realizados'] ?></h2>
            </div>
        </div>

        <!-- === Treino mais realizado === -->
        <div class="alert">
            <strong>🏋️ Treino mais realizado:</strong>
            <?php echo $usuarionmtreino['nome_treino'] ?? 'Nenhum treino encontrado' ?>
            (<?php echo $usuarionmtreino['vezes_realizado'] ?? 0 ?> vezes)
        </div>

        <!-- === Usuários e seus treinos === -->
        <div class="card">
            <div class="card-header">Usuários e seus Treinos</div>
            <div class="card-body">
                <table>
                    <thead>
                        <tr>
                            <th>Usuário</th>
                            <th>Treino</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($linha = mysqli_fetch_assoc($resultadousuario)) {
                            echo "<tr>";
                            echo "<td>{$linha['nome_usuario']}</td>";
                            echo "<td>{$linha['nome_treino']}</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- === Histórico de Treinos === -->
        <div class="card" style="margin-top:20px;">
            <div class="card-header">Últimos Treinos Realizados</div>
            <div class="card-body">
                <table>
                    <thead>
                        <tr>
                            <th>Usuário</th>
                            <th>Treino</th>
                            <th>Data</th>
                            <th>Duração (min)</th>
                            <th>Observações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($linha = mysqli_fetch_assoc($resultadohistorico)) {
                            echo "<tr>";
                            echo "<td>{$linha['usuario']}</td>";
                            echo "<td>{$linha['nome_treino']}</td>";
                            echo "<td>{$linha['data_treino']}</td>";
                            echo "<td>{$linha['duracao_minutos']}</td>";
                            echo "<td>{$linha['observacoes']}</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- === Treinos e Exercícios === -->
        <div class="card" style="margin-top:20px;">
            <div class="card-header">Treinos e seus Exercícios</div>
            <div class="card-body">
                <table>
                    <thead>
                        <tr>
                            <th>Treino</th>
                            <th>Exercício</th>
                            <th>Séries</th>
                            <th>Repetições</th>
                            <th>Carga (kg)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($linha = mysqli_fetch_assoc($resultadotrn)) {
                            echo "<tr>";
                            echo "<td>{$linha['nome_treino']}</td>";
                            echo "<td>{$linha['nome_exercicio']}</td>";
                            echo "<td>{$linha['series']}</td>";
                            echo "<td>{$linha['repeticoes']}</td>";
                            echo "<td>{$linha['carga']}</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</body>

</html>