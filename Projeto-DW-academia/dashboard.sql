SELECT COUNT(*) AS total_usuarios
FROM usuario;

SELECT COUNT(*) AS total_treinos
FROM treino;

SELECT COUNT(*) AS total_exercicios
FROM exercicio;

SELECT COUNT(*) AS total_treinos_realizados
FROM historico_treino;

SELECT 
    u.id_usuario,
    u.nome AS nome_usuario,
    t.nome_treino
FROM usuario AS u
JOIN usuario_treino AS ut ON u.id_usuario = ut.usuario_id_usuario
JOIN treino AS t ON t.id_treino = ut.treino_id_treino
ORDER BY u.nome;

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

SELECT 
    t.nome_treino,
    COUNT(h.treino_id) AS vezes_realizado
FROM historico_treino AS h
JOIN treino AS t ON t.id_treino = h.treino_id
GROUP BY t.id_treino
ORDER BY vezes_realizado DESC
LIMIT 1;
