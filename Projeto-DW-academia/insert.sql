USE `academia`;

-- TABELA: exercicio (inserts com ids explícitos)
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

-- TABELA: exercicio (inserts adicionais sem id — serão auto-incrementados)
INSERT INTO `academia`.`exercicio` (`nome_exercicio`, `series`, `repeticoes`, `carga`) VALUES
('Agachamento', 4, 12, 60.00),
('Supino reto', 3, 10, 80.00),
('Puxada na barra', 4, 12, 0.00),
('Levantamento terra', 3, 10, 100.00),
('Desenvolvimento com halteres', 3, 12, 20.00),
('Rosca direta', 4, 12, 18.00),
('Leg press', 4, 10, 120.00),
('Mergulho', 3, 15, 0.00),
('Stiff', 3, 10, 90.00),
('Pull-over', 3, 12, 0.00);

-- TABELA: treino (inserts com ids explícitos)
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

-- TABELA: treino (inserts adicionais sem id)
INSERT INTO `academia`.`treino` (`nome_treino`, `descricao`) VALUES
('Treino A', 'Treino de membros superiores focado em força'),
('Treino B', 'Treino de membros inferiores e core'),
('Treino C', 'Treino de resistência para corrida'),
('Treino D', 'Treino full body com foco em hipertrofia'),
('Treino E', 'Treino de força para pernas e glúteos'),
('Treino F', 'Treino de peito e tríceps para definição'),
('Treino G', 'Treino de costas e bíceps para volume'),
('Treino H', 'Treino de alta intensidade para emagrecimento'),
('Treino I', 'Treino específico para aumento de resistência muscular'),
('Treino J', 'Treino de abdômen e core com exercícios funcionais');

-- TABELA: usuario (inserts com ids explícitos)
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

-- TABELA: usuario (inserts adicionais sem id)
INSERT INTO `academia`.`usuario` (`nome`, `email`, `senha`, `idade`) VALUES
('Carlos Silva', 'carlos.silva@email.com', 'senha123', 34),
('Ana Souza', 'ana.souza@email.com', '123senha', 37),
('Lucas Pereira', 'lucas.pereira@email.com', '1234abcd', 29),
('Fernanda Almeida', 'fernanda.almeida@email.com', 'abcd1234', 32),
('Rafael Costa', 'rafael.costa@email.com', 'rafael2025', 36),
('Juliana Lima', 'juliana.lima@email.com', 'juliana2025', 28),
('Gustavo Santos', 'gustavo.santos@email.com', 'senha_gustavo', 33),
('Mariana Rocha', 'mariana.rocha@email.com', 'mariana2025', 39),
('Diego Martins', 'diego.martins@email.com', 'diego@123', 27),
('Paula Oliveira', 'paula.oliveira@email.com', 'senhaPaula', 31);

-- TABELA: usuario_treino (união dos pares, sem duplicações idênticas)
INSERT INTO usuario_treino (usuario_id_usuario, treino_id_treino) VALUES
(1, 1),
(1, 3),
(2, 2),
(2, 5),
(3, 3),
(3, 4),
(4, 1),
(4, 4),
(5, 5),
(5, 6),
(6, 3),
(6, 6),
(7, 7),
(8, 2),
(8, 8),
(9, 9),
(10, 10);

-- TABELA: exercicio_treino (união dos pares, sem duplicações idênticas)
INSERT INTO exercicio_treino (exercicio_id, treino_id) VALUES
(1, 1),
(2, 1),
(3, 1),
(6, 1),
(1, 2), 
(3, 2),
(4, 2),
(5, 2),
(2, 3),
(4, 3),
(6, 3),
(8, 3),
(9, 4),
(7, 4),
(8, 4),
(9, 5),
(10, 5);

-- TABELA: historico_treino (todos os registros)
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
(10, 5, '2025-10-10', 30, 'Abdômen queimando!'),
(1, 1, '2025-10-05', 60, 'Treino de força para membros superiores'),
(2, 2, '2025-10-06', 50, 'Treino de resistência com foco em pernas'),
(3, 3, '2025-10-07', 40, 'Treino aeróbico para resistência cardiovascular'),
(4, 4, '2025-10-08', 70, 'Treino de hipertrofia com foco no corpo inteiro'),
(5, 5, '2025-10-09', 60, 'Treino de pernas e glúteos com alta carga'),
(6, 6, '2025-10-10', 55, 'Treino de peito e tríceps para definição muscular'),
(7, 7, '2025-10-11', 45, 'Treino de costas e bíceps com foco em volume muscular'),
(8, 8, '2025-10-12', 60, 'Treino HIIT para emagrecimento'),
(9, 9, '2025-10-13', 50, 'Treino de resistência muscular para aumento de força'),
(10, 10, '2025-10-14', 45, 'Treino funcional para fortalecimento de core');
