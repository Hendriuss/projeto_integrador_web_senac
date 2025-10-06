-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.4.32-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.11.0.7065
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para ospina
CREATE DATABASE IF NOT EXISTS `ospina` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `ospina`;

-- Copiando estrutura para tabela ospina.clientes
CREATE TABLE IF NOT EXISTS `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela ospina.clientes: ~2 rows (aproximadamente)
INSERT INTO `clientes` (`id`, `nome`, `email`, `telefone`, `criado_em`) VALUES
	(1, 'João Silva', 'joao@email.com', '11999999999', '2025-09-23 19:32:35'),
	(2, 'Maria Santos', 'maria@email.com', '11988888888', '2025-09-23 19:32:35');

-- Copiando estrutura para tabela ospina.contato
CREATE TABLE IF NOT EXISTS `contato` (
  `idContato` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `descricao` text NOT NULL,
  PRIMARY KEY (`idContato`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela ospina.contato: ~2 rows (aproximadamente)
INSERT INTO `contato` (`idContato`, `nome`, `email`, `descricao`) VALUES
	(1, 'João', 'joao@gmail.com', 'Assunto: sfsfsd | Mensagem: eddd'),
	(2, 'Gabriel', 'gac@gmail.com', 'Assunto: Perfume | Mensagem: Pouco Perfume tem no site ');

-- Copiando estrutura para tabela ospina.pedidos
CREATE TABLE IF NOT EXISTS `pedidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome_cliente` varchar(255) NOT NULL,
  `email_cliente` varchar(255) NOT NULL,
  `endereco` text NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `metodo_pagamento` varchar(50) NOT NULL,
  `data_pedido` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela ospina.pedidos: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela ospina.produtos
CREATE TABLE IF NOT EXISTS `produtos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `preco` decimal(10,2) NOT NULL,
  `estoque` int(11) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `referencia` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela ospina.produtos: ~3 rows (aproximadamente)
INSERT INTO `produtos` (`id`, `nome`, `descricao`, `preco`, `estoque`, `imagem`, `criado_em`, `referencia`) VALUES
	(1, 'Essência Floral', 'Perfume com aroma floral suave', 129.90, 50, 'img/perfume1.jpg', '2025-09-23 19:32:35', NULL),
	(2, 'Toque de Jasmim', 'Perfume com aroma de jasmim', 149.90, 30, 'img/perfume2.jpg', '2025-09-23 19:32:35', NULL),
	(3, 'Aroma do Oriente', 'Perfume com notas orientais', 179.90, 20, 'img/perfume3.jpg', '2025-09-23 19:32:35', NULL);

-- Copiando estrutura para tabela ospina.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `login` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `nivel` enum('admin','vendedor') DEFAULT 'vendedor',
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela ospina.usuarios: ~4 rows (aproximadamente)
INSERT INTO `usuarios` (`id`, `nome`, `login`, `senha`, `nivel`, `criado_em`) VALUES
	(3, 'Carol', 'Carol@gmail.com', '$2y$10$Ri/DbtbTPPJyR.6Oi6USC.yQbu3u3zS3SLlzi2eSq5dFhaEweqaQC', 'vendedor', '2025-09-24 18:08:30'),
	(4, 'Manu leticia', 'manu@gmail.com', '$2y$10$PCapHFU7pfTN.F4uXnmwquWa7hwk4MQg324sBJdSS0BE0W6SC/3rO', 'vendedor', '2025-09-29 17:16:40'),
	(5, 'Hendrius da silva', 'hendrius@gmail.com', '$2y$10$.DddXYYYHk1bDjUVXGKHvO6p3wljWQZmxbqlWWpe.0U62lMo/PH9e', 'vendedor', '2025-09-29 18:06:26'),
	(6, 'Gabriel', 'gac@gmail.com', '$2y$10$3xDWNCQg8A3tBIDpATmSf.8mC/MkgJYPztTTnl4KlTxBa16o86qvi', 'vendedor', '2025-09-30 19:52:26');

-- Copiando estrutura para tabela ospina.vendas
CREATE TABLE IF NOT EXISTS `vendas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL DEFAULT 1,
  `total` decimal(10,2) NOT NULL,
  `data_venda` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `cliente_id` (`cliente_id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `produto_id` (`produto_id`),
  CONSTRAINT `vendas_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `vendas_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `vendas_ibfk_3` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela ospina.vendas: ~0 rows (aproximadamente)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
