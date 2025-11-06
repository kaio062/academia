USE academia;

-- ==============================
-- 1. INSERINDO EXERCÍCIOS
-- ==============================
INSERT INTO `exercício` (`id_exercicio`, `nome_exercicio`, `series`, `repeticoes`, `carga`) VALUES
(1, 'Supino Reto', 4, 10, 60.00),
(2, 'Agachamento Livre', 4, 12, 80.00),
(3, 'Rosca Direta', 3, 10, 25.00),
(4, 'Tríceps Corda', 3, 12, 20.00),
(5, 'Puxada Frontal', 4, 10, 50.00),
(6, 'Desenvolvimento Ombro', 3, 10, 30.00),
(7, 'Cadeira Extensora', 4, 12, 45.00),
(8, 'Flexora', 4, 12, 40.00),
(9, 'Abdominal Supra', 3, 15, 0.00),
(10, 'Panturrilha Sentado', 4, 20, 35.00);

-- ==============================
-- 2. INSERINDO TREINOS
-- ==============================
INSERT INTO `treino` (`id_treino`, `nome_treino`, `descricao`) VALUES
(1, 'Treino A', 'Peito e tríceps'),
(2, 'Treino B', 'Costas e bíceps'),
(3, 'Treino C', 'Pernas'),
(4, 'Treino D', 'Ombros e abdômen'),
(5, 'Treino E', 'Corpo inteiro leve'),
(6, 'Treino F', 'Resistência e força'),
(7, 'Treino G', 'Hipertrofia geral'),
(8, 'Treino H', 'Treino funcional'),
(9, 'Treino I', 'Cardio e resistência'),
(10, 'Treino J', 'Mobilidade e alongamento');

-- ==============================
-- 3. LIGAÇÃO EXERCÍCIO_TREINO
-- ==============================
INSERT INTO `exercicio_treino` (`exercício_id`, `treino_id`) VALUES
(1, 1),
(4, 1),
(5, 2),
(3, 2),
(2, 3),
(7, 3),
(8, 3),
(6, 4),
(9, 4),
(10, 4);

-- ==============================
-- 4. INSERINDO USUÁRIOS
-- ==============================
INSERT INTO `usuario` (`id_usuario`, `nome`, `email`, `senha`, `idade`, `data_cadastro`) VALUES
(1, 'Ana Souza', 'ana@example.com', '123456', '1995-04-10', NOW()),
(2, 'Bruno Lima', 'bruno@example.com', '123456', '1990-01-20', NOW()),
(3, 'Carla Dias', 'carla@example.com', '123456', '1998-03-15', NOW()),
(4, 'Daniel Costa', 'daniel@example.com', '123456', '1987-06-25', NOW()),
(5, 'Eduarda Pires', 'eduarda@example.com', '123456', '1999-08-30', NOW()),
(6, 'Felipe Nunes', 'felipe@example.com', '123456', '1992-09-12', NOW()),
(7, 'Gabriela Ramos', 'gabriela@example.com', '123456', '1996-12-05', NOW()),
(8, 'Henrique Alves', 'henrique@example.com', '123456', '1994-07-19', NOW()),
(9, 'Isabela Martins', 'isabela@example.com', '123456', '2000-02-22', NOW()),
(10, 'João Ferreira', 'joao@example.com', '123456', '1985-11-11', NOW());

-- ==============================
-- 5. LIGAÇÃO USUÁRIO_TREINO
-- ==============================
INSERT INTO `usuario_treino` (`usuario_id_usuario`, `treino_id_treino`) VALUES
(1, 1),
(1, 2),
(2, 3),
(3, 1),
(4, 4),
(5, 2),
(6, 3),
(7, 5),
(8, 6),
(9, 4),
(10, 7);
