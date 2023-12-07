-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 07/12/2023 às 03:09
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `cafe`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `carrinho`
--

CREATE TABLE `carrinho` (
  `id_carrinho` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_produto` int(11) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `chave_carrinho_temp` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `cep` varchar(8) NOT NULL,
  `rua` varchar(255) NOT NULL,
  `numero_casa` int(20) NOT NULL,
  `pagamento` varchar(50) NOT NULL,
  `troco` varchar(100) NOT NULL,
  `whatsapp` varchar(100) NOT NULL,
  `obs` varchar(255) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `data_pedido` timestamp NOT NULL DEFAULT current_timestamp(),
  `valor_total` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id_produto` int(11) NOT NULL,
  `nome_produto` varchar(255) NOT NULL,
  `descricao` varchar(200) NOT NULL,
  `preco` float NOT NULL,
  `foto_produto` varchar(200) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `destaque` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id_produto`, `nome_produto`, `descricao`, `preco`, `foto_produto`, `tipo`, `destaque`) VALUES
(1, 'Vanilla Latte', 'Um toque clássico', 16.99, 'foto_produto/latte.png', 'cafe', 0),
(2, 'Affogato', 'Refrescante e equilibrado', 19.99, 'foto_produto/affogato.png', 'cafe', 0),
(3, 'Spiced Espresso Flat White', 'Deliciosas Notas de Sabor', 24.99, 'foto_produto/spiced.png', 'cafe', 1),
(4, 'Caffé Americano', 'Delicioso e simples', 14.99, 'foto_produto/americano.png', 'cafe', 0),
(5, 'Iced Latte', 'Fresca e Refrescante', 19.99, 'foto_produto/icedlatte.png', 'cafe', 0),
(6, 'Caffé Mocha', 'Um clássico Garden', 19.99, 'foto_produto/mocha.png', 'cafe', 0),
(7, 'Capuccino', 'Um carimbo do Garden', 17.99, 'foto_produto/capuccino.png', 'cafe', 1),
(8, 'Iced Caramel Macchiato', 'Rico e com toque de baunilha', 24.99, 'foto_produto/iced.png', 'cafe', 0),
(9, 'Latte Macchiato', 'Cheio de sabor', 14.99, 'foto_produto/latte.png', 'cafe', 0),
(10, 'Garden Blond Vanilla Latte', 'Suave e aveludado', 19.99, 'foto_produto/garden.png', 'cafe', 0),
(11, 'Sparkling Espresso with Mint', 'Um toque Brilhante', 24.99, 'foto_produto/sparkling.png', 'cafe', 0),
(12, 'Arranjo de Rosas Vermelhas', 'Desperte paixões com a elegância atemporal das nossas rosas vermelhas.', 139.9, 'foto_produto/arranjo15rosas.png', 'flor', 0),
(13, 'Arranjo de Girassóis', 'Brilhe como o sol com nosso arranjo radiante de girassóis.', 169.9, 'foto_produto/arranjogirassol.png', 'flor', 0),
(14, 'Buquê Rosas Mistas', 'Um buquê de elegância, misturando rosas vermelhas e rosas para transmitir paixão e carinho.', 149.9, 'foto_produto/buque15rosasmistas.png', 'flor', 0),
(15, 'Buquê Rosas Coloridas', 'Um arco-íris de beleza floral: nosso buquê de rosas coloridas traz alegria e vivacidade em cada pétala.', 209.9, 'foto_produto/buque24rosascoloridas.png', 'flor', 0),
(16, 'Buquê Rosas Vermelhas', 'Um buquê de rosas vermelhas, a expressão clássica do amor apaixonado.', 159.9, 'foto_produto/buque24rosasvermelhas.png', 'flor', 1),
(17, 'Buquê de Girassol', 'Um buquê de girassóis, o símbolo do otimismo e da alegria, para iluminar qualquer ocasião.', 139.9, 'foto_produto/buquegirassol.png', 'flor', 0),
(18, 'Buquê de Lírios e Rosas Vermelhas', 'Combine a elegância dos lírios com a paixão das rosas vermelhas em um buquê que exala amor e sofisticação.', 159.9, 'foto_produto/buqueliriosrosasvermelhas.png', 'flor', 0),
(19, 'Cesta de Rosas Vermelhas', 'Presenteie com a beleza e o encanto das rosas vermelhas em uma cesta apaixonante.', 159.9, 'foto_produto/cestarosas.png', 'flor', 0),
(20, 'Arranjo Flores Vermelhas Mistas', 'Expresse emoções intensas com nosso arranjo de flores vermelhas mistas, uma explosão de paixão e beleza.', 119.9, 'foto_produto/floresvermelhasmistas.png', 'flor', 0),
(21, 'Orquídea Phanaenopsis', 'Eleve o ambiente com a elegância atemporal da orquídea Phalaenopsis.', 159.9, 'foto_produto/orquideaphanaenopsis.png', 'flor', 0),
(22, 'Orquídea Phanaenopsis Pink', 'Adicione um toque de sofisticação com a orquídea Phalaenopsis pink, a beleza que encanta e inspira.', 169.9, 'foto_produto/orquideaphanaenopsispink.png', 'flor', 0),
(23, 'Orquídea Phanaenopsis Rosa', 'Embeleze qualquer espaço com a delicadeza da orquídea Phalaenopsis rosa.', 159.9, 'foto_produto/orquideaphanaenopsisrosa.png', 'flor', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos_pedido`
--

CREATE TABLE `produtos_pedido` (
  `id_produtos_pedido` int(11) NOT NULL,
  `id_pedido` int(11) DEFAULT NULL,
  `id_produto` int(11) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `cep` varchar(255) NOT NULL,
  `rua` varchar(255) NOT NULL,
  `numero_casa` varchar(255) NOT NULL,
  `adm` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `cep`, `rua`, `numero_casa`, `adm`) VALUES
(3, 'Mariana', 'gab@gmail.com', '$2y$10$HH/0a0te9Q7QA5.6xrHh6O1JhSeVh5Tb6idhQeYyzly/I25v6O05e', '81740719', 'UU', '66', 1),
(4, 'Mari', 'gabs@gmail.com', '$2y$10$PXEQzfNBJbIPNT8c5or0euJo2MRBZ99zztxL3MZB5ehaVrcYMwaKm', '81740719', 'UU', '45', 0),
(5, 'Mateus', 'mateusleite2709@gmail.com', '$2y$10$uP4QRrd73RzKOzdh7WfO8Oldn1IRu2luXvTI5l5eHMjmqtXAxz/De', '81450-719', 'Rua Douglas Ribeiro de Souza', '66', 0),
(6, 'Mari', 'mariana@gmail.com', '$2y$10$XA2XHJyFMC14U2xkuEhEp.fRylFPV0cWJdPQJUzIl8.2SqqtXabF6', '81350268', 'Rua Leonor Fiori Granato', '171', 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `carrinho`
--
ALTER TABLE `carrinho`
  ADD PRIMARY KEY (`id_carrinho`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_produto` (`id_produto`);

--
-- Índices de tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id_produto`);

--
-- Índices de tabela `produtos_pedido`
--
ALTER TABLE `produtos_pedido`
  ADD PRIMARY KEY (`id_produtos_pedido`),
  ADD KEY `id_pedido` (`id_pedido`),
  ADD KEY `id_produto` (`id_produto`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `carrinho`
--
ALTER TABLE `carrinho`
  MODIFY `id_carrinho` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `produtos_pedido`
--
ALTER TABLE `produtos_pedido`
  MODIFY `id_produtos_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `carrinho`
--
ALTER TABLE `carrinho`
  ADD CONSTRAINT `carrinho_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `carrinho_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id_produto`);

--
-- Restrições para tabelas `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Restrições para tabelas `produtos_pedido`
--
ALTER TABLE `produtos_pedido`
  ADD CONSTRAINT `produtos_pedido_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`),
  ADD CONSTRAINT `produtos_pedido_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id_produto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
