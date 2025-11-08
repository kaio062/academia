USE `academia`;

INSERT INTO exercicio (id_exercicio, nome_exercicio, series, repeticoes, carga) VALUES
(1, 'Supino Reto', 4, 10, 60.00),
(2, 'Agachamento Livre', 4, 12, 80.00),
(3, 'Puxada Frontal', 3, 10, 50.00),
(4, 'Leg Press', 4, 15, 150.00),
(5, 'Rosca Direta', 3, 12, 25.00),
(6, 'Tríceps Corda', 3, 12, 30.00),
(7, 'Remada Curvada', 4, 10, 55.00),
(8, 'Cadeira Extensora', 4, 15, 70.00),
(9, 'Elevação Lateral', 3, 12, 12.00),
(10, 'Abdominal Supra', 3, 20, 0.00);
INSERT INTO treino (id_treino, nome_treino, descricao) VALUES
(1, 'Treino A - Peito e Tríceps', 'Exercícios focados em peito e tríceps.'),
(2, 'Treino B - Costas e Bíceps', 'Exercícios voltados para costas e bíceps.'),
(3, 'Treino C - Pernas', 'Exercícios para quadríceps, posteriores e glúteos.'),
(4, 'Treino D - Ombros e Trapézio', 'Exercícios para desenvolvimento de ombros.'),
(5, 'Treino E - Abdômen', 'Treino voltado para a região abdominal.'),
(6, 'Treino F - Corpo Inteiro', 'Treino completo para todos os grupos musculares.'),
(7, 'Treino G - Cardio', 'Treino de resistência cardiovascular.'),
(8, 'Treino H - Glúteos', 'Foco no fortalecimento dos glúteos.'),
(9, 'Treino I - Mobilidade', 'Treino leve para flexibilidade.'),
(10, 'Treino J - Potência', 'Exercícios explosivos para força máxima.'); 
INSERT INTO usuario (id_usuario, nome, email, senha, idade) VALUES
(1, 'Carlos Silva', 'carlos@email.com', '123', 35),
(2, 'Ana Souza', 'ana@email.com', '123', 30),
(3, 'Lucas Pereira', 'lucas@email.com', '123', 27),
(4, 'Mariana Costa', 'mariana@email.com', '123', 33),
(5, 'Felipe Gomes', 'felipe@email.com', '123', 25),
(6, 'Juliana Rocha', 'juliana@email.com', '123', 28),
(7, 'Rafael Santos', 'rafael@email.com', '123', 32),
(8, 'Amanda Lima', 'amanda@email.com', '123', 29),
(9, 'Bruno Almeida', 'bruno@email.com', '123', 36),
(10, 'Beatriz Oliveira', 'beatriz@email.com', '123', 31);

INSERT INTO usuario_treino (usuario_id_usuario, treino_id_treino) VALUES
(1, 1),
(1, 3),
(2, 2),
(2, 5),
(3, 4),
(4, 1),
(5, 6),
(6, 3),
(7, 7),
(8, 2);
INSERT INTO historico_treino (usuario_id, treino_id, data_treino, duracao_minutos, observacoes) VALUES
(1, 1, '2025-10-01', 60, 'Bom rendimento'),
(2, 2, '2025-10-02', 55, 'Cansada, mas completou'),
(3, 4, '2025-10-03', 45, 'Execução perfeita'),
(4, 1, '2025-10-04', 50, 'Aumentou carga no supino'),
(5, 6, '2025-10-05', 70, 'Excelente resistência'),
(6, 3, '2025-10-06', 65, 'Cansou nas últimas séries'),
(7, 7, '2025-10-07', 40, 'Boa performance no cardio'),
(8, 2, '2025-10-08', 55, 'Manteve ritmo constante'),
(9, 3, '2025-10-09', 60, 'Força nas pernas aumentou'),
(10, 5, '2025-10-10', 30, 'Abdômen queimando!');
INSERT INTO exercicio_treino (exercicio_id, treino_id) VALUES
(1, 1),
(6, 1),
(3, 2),
(5, 2),
(2, 3),
(4, 3),
(9, 4),
(7, 4),
(10, 5),
(8, 3);
