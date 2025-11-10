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
<style>/* === 🎯 VARIÁVEIS DE TEMA === */
:root {
    --bg-color: #0a0a0a;
    --sidebar-bg: #0d0d0d;
    --card-bg: #111111;
    --primary-color: #00ff88;
    --primary-glow: #00ff88cc;
    --accent-color: #0aff9d;
    --text-color: #e5e5e5;
    --text-secondary: #8a8a8a;
    --hover-bg: rgba(0, 255, 136, 0.08);
    --border-color: rgba(0, 255, 136, 0.15);
    --radius: 14px;
    --shadow-glow: 0 0 18px rgba(0, 255, 136, 0.15);
    --transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
}

/* === 🌙 BASE === */
body {
    font-family: "Poppins", "Segoe UI", Arial, sans-serif;
    background: radial-gradient(circle at top left, #090909, #000);
    color: var(--text-color);
    margin: 0;
    padding: 0;
    line-height: 1.6;
    overflow-x: hidden;
}

/* Barra de rolagem estilizada */
::-webkit-scrollbar {
    width: 6px;
}
::-webkit-scrollbar-thumb {
    background: var(--accent-color);
    border-radius: 10px;
}
::-webkit-scrollbar-track {
    background: #0f0f0f;
}

/* === 🧭 SIDEBAR === */
.sidebar {
    width: 250px;
    background: linear-gradient(180deg, #0d0d0d, #080808);
    box-shadow: inset -1px 0 0 var(--border-color), var(--shadow-glow);
    position: fixed;
    left: 0;
    top: 0;
    bottom: 0;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    overflow: hidden;
    transition: var(--transition);
    z-index: 100;
    backdrop-filter: blur(6px);
}

.sidebar.collapsed {
    width: 85px;
}

/* Cabeçalho */
.sidebar-header {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 24px 18px;
    color: var(--primary-color);
    font-weight: 700;
    font-size: 1.4em;
    text-shadow: 0 0 12px var(--primary-color);
    letter-spacing: -0.5px;
    white-space: nowrap;
    border-bottom: 1px solid var(--border-color);
}

/* === MENU === */
.menu {
    list-style: none;
    padding: 25px 0;
    margin: 0;
    flex: 1;
    overflow-y: auto;
}

.menu li {
    margin: 6px 0;
}

.menu a {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 12px 24px;
    color: var(--text-color);
    text-decoration: none;
    border-radius: 10px;
    transition: var(--transition);
    position: relative;
    font-weight: 500;
}

.menu a span {
    font-size: 1.4em;
    min-width: 36px;
    text-align: center;
}

.menu a:hover {
    background: var(--hover-bg);
    color: var(--primary-color);
    box-shadow: 0 0 16px rgba(0, 255, 136, 0.25);
    transform: translateX(6px);
}

.menu a.active {
    background: rgba(0, 255, 136, 0.12);
    color: var(--primary-color);
    box-shadow: inset 3px 0 0 var(--primary-color);
}

/* Seções do menu */
.menu h4 {
    color: var(--primary-color);
    font-size: 0.9em;
    margin: 12px 0;
    text-align: center;
    letter-spacing: 0.5px;
    opacity: 0.85;
    text-shadow: 0 0 6px var(--primary-glow);
    transition: var(--transition);
}

hr {
    border: none;
    height: 1px;
    background: var(--border-color);
    margin: 14px 20px;
}

/* Botão de recolher */
.toggle-btn {
    background: none;
    border: none;
    color: var(--primary-color);
    font-size: 1.5em;
    cursor: pointer;
    padding: 16px;
    transition: transform 0.4s ease;
}

.toggle-btn:hover {
    transform: rotate(90deg) scale(1.2);
}

/* Sidebar recolhida */
.sidebar.collapsed .menu p,
.sidebar.collapsed .menu h4,
.sidebar.collapsed .sidebar-header .titulo {
    opacity: 0;
    transform: translateX(-15px);
    pointer-events: none;
}

.sidebar.collapsed .menu a {
    justify-content: center;
}

.sidebar.collapsed .menu span {
    margin: 0 auto;
}

/* === 🏋️ CONTEÚDO PRINCIPAL === */
.container {
    width: 90%;
    max-width: 1200px;
    margin: 50px auto 50px 280px;
    transition: var(--transition);
}

.sidebar.collapsed ~ .container {
    margin-left: 110px;
}
.sidebar-tooltip {
    position: fixed;
    background: rgba(0, 255, 136, 0.15);
    color: var(--primary-color);
    padding: 6px 10px;
    border-radius: 6px;
    font-size: 0.85em;
    backdrop-filter: blur(6px);
    box-shadow: 0 0 10px rgba(0, 255, 136, 0.25);
    pointer-events: none;
    animation: fadeIn 0.2s ease;
    z-index: 999;
}

/* === CABEÇALHO === */
.dashboard-header {
    text-align: center;
    margin-bottom: 40px;
    animation: fadeInDown 0.6s ease;
}

.dashboard-header h1 {
    margin: 0;
    font-size: 2.4em;
    font-weight: 700;
    color: var(--primary-color);
    letter-spacing: -0.5px;
    text-shadow: 0 0 15px var(--primary-color);
}

.dashboard-header p {
    color: var(--text-secondary);
    margin-top: 8px;
    font-size: 1em;
}

/* === 📊 CARDS === */
.row {
    display: flex;
    flex-wrap: wrap;
    gap: 22px;
    justify-content: center;
    margin-bottom: 50px;
}

.card {
    background: linear-gradient(145deg, #101010, #0b0b0b);
    border-radius: var(--radius);
    box-shadow: 0 6px 25px var(--card-shadow);
    padding: 28px;
    min-width: 240px;
    flex: 1;
    text-align: center;
    cursor: pointer;
    transition: var(--transition);
    border: 1px solid transparent;
}

.card:hover {
    transform: translateY(-6px);
    border: 1px solid var(--primary-color);
    box-shadow: 0 0 25px rgba(0, 255, 136, 0.25);
}

.card h5 {
    color: var(--text-secondary);
    font-weight: 500;
    margin-bottom: 8px;
}

.card h2 {
    color: var(--primary-color);
    font-size: 2em;
    font-weight: 700;
    margin: 0;
    text-shadow: 0 0 10px var(--primary-color);
}

/* === 🔔 ALERT === */
.alert {
    background: rgba(0, 255, 136, 0.08);
    border-left: 5px solid var(--primary-color);
    color: var(--primary-color);
    padding: 18px;
    text-align: center;
    border-radius: var(--radius);
    margin-bottom: 40px;
    font-weight: 500;
    box-shadow: 0 0 12px rgba(0, 255, 136, 0.2);
    animation: fadeIn 0.8s ease;
}

/* === 📋 TABELAS === */
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

/* === ✨ ANIMAÇÕES === */
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

/* === 📱 RESPONSIVO === */
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
    <!-- Cabeçalho da Sidebar -->
    <div class="sidebar-header">
        <span class="logo">🏋️</span>
        <span class="titulo">Academia</span>
    </div>

    <!-- Menu Principal -->
    <ul class="menu">
        <!-- Seção Dashboard -->
        <li>
            <a href="dashboard.php" class="active" aria-current="page">
                <span>🏠</span>
                <p>Dashboard</p>
            </a>
        </li>

        <li>
            <a href="logout.php">
                <span>🚪</span>
                <p>Sair</p>
            </a>
        </li>

        <hr>

        <!-- Seção Treino -->
        <h4>🏋️ Treino</h4>
        <li>
            <a href="treino.php">
                <span>➕</span>
                <p>Cadastrar</p>
            </a>
        </li>
        <li>
            <a href="listar_treino.php">
                <span>📋</span>
                <p>Listar</p>
            </a>
        </li>

        <hr>

        <!-- Seção Exercício -->
        <h4>💪 Exercício</h4>
        <li>
            <a href="exercicio.php">
                <span>➕</span>
                <p>Cadastrar</p>
            </a>
        </li>
        <li>
            <a href="listar_exercicios.php">
                <span>📋</span>
                <p>Listar</p>
            </a>
        </li>

        <hr>

        <!-- Seção Usuário -->
        <h4>👤 Usuário</h4>
        <li>
            <a href="usuario.php">
                <span>➕</span>
                <p>Cadastrar</p>
            </a>
        </li>
        <li>
            <a href="listar_usuario.php">
                <span>📋</span>
                <p>Listar</p>
            </a>
        </li>
    </ul>

    <!-- Botão de recolher/expandir -->
    <button class="toggle-btn" id="toggleSidebar" title="Expandir/Recolher menu">
        ☰
    </button>
</nav>




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
<script>
    const toggle = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');
    const menuTexts = sidebar.querySelectorAll('.menu p, .menu h4, .sidebar-header .titulo');

    // 🔄 Restaura estado salvo (aberto ou recolhido)
    const savedState = localStorage.getItem('sidebar-collapsed');
    if (savedState === 'true') {
        sidebar.classList.add('collapsed');
        hideMenuText();
    }

    // 🎛 Alterna menu
    toggle.addEventListener('click', () => {
        const isCollapsed = sidebar.classList.toggle('collapsed');
        if (isCollapsed) hideMenuText();
        else showMenuText();
        localStorage.setItem('sidebar-collapsed', isCollapsed);
    });

    // 🔥 Função: esconde textos com animação
    function hideMenuText() {
        menuTexts.forEach(el => {
            el.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
            el.style.opacity = '0';
            el.style.transform = 'translateX(-15px)';
            setTimeout(() => (el.style.display = 'none'), 250);
        });
    }

    // ✨ Função: mostra textos suavemente
    function showMenuText() {
        menuTexts.forEach(el => {
            el.style.display = 'block';
            setTimeout(() => {
                el.style.opacity = '1';
                el.style.transform = 'translateX(0)';
            }, 50);
        });
    }

    // 💬 Tooltips automáticos ao recolher
    sidebar.querySelectorAll('.menu a').forEach(link => {
        const text = link.querySelector('p')?.textContent || '';
        link.setAttribute('data-tooltip', text);
    });

    // Mostra tooltip apenas se recolhido
    sidebar.addEventListener('mouseover', e => {
        if (!sidebar.classList.contains('collapsed')) return;
        const link = e.target.closest('.menu a');
        if (!link || !link.dataset.tooltip) return;

        const tooltip = document.createElement('div');
        tooltip.className = 'sidebar-tooltip';
        tooltip.textContent = link.dataset.tooltip;
        document.body.appendChild(tooltip);

        const rect = link.getBoundingClientRect();
        tooltip.style.left = rect.right + 10 + 'px';
        tooltip.style.top = rect.top + 'px';

        link.addEventListener('mouseleave', () => tooltip.remove(), { once: true });
    });
</script>


</body>

</html>