-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.4.32-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.4.0.6659
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para db_tecnofit
DROP DATABASE IF EXISTS `db_tecnofit`;
CREATE DATABASE IF NOT EXISTS `db_tecnofit` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `db_tecnofit`;

-- Copiando estrutura para tabela db_tecnofit.movement
DROP TABLE IF EXISTS `movement`;
CREATE TABLE IF NOT EXISTS `movement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela db_tecnofit.movement: ~10 rows (aproximadamente)
DELETE FROM `movement`;
INSERT INTO `movement` (`id`, `name`) VALUES
	(1, 'Deadlift'),
	(2, 'Back Squat'),
	(3, 'Bench Press'),
	(4, 'Box Jump'),
	(5, 'Ring Dip'),
	(6, 'Ring Muscle-Up'),
	(7, 'Wall Ball'),
	(8, 'Medicine Ball Clean'),
	(9, 'Kettlebell Swing'),
	(10, 'Air Squat');

-- Copiando estrutura para tabela db_tecnofit.personal_record
DROP TABLE IF EXISTS `personal_record`;
CREATE TABLE IF NOT EXISTS `personal_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `movement_id` int(11) NOT NULL,
  `value` float NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `personal_record_ 0` (`user_id`),
  KEY `personal_record_ 1` (`movement_id`),
  CONSTRAINT `personal_record_ 0` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `personal_record_ 1` FOREIGN KEY (`movement_id`) REFERENCES `movement` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela db_tecnofit.personal_record: ~0 rows (aproximadamente)
DELETE FROM `personal_record`;
INSERT INTO `personal_record` (`id`, `user_id`, `movement_id`, `value`, `date`) VALUES
	(1, 1, 1, 100, '2021-01-01 00:00:00'),
	(2, 1, 1, 180, '2021-01-02 00:00:00'),
	(3, 1, 1, 150, '2021-01-03 00:00:00'),
	(4, 1, 1, 110, '2021-01-04 00:00:00'),
	(5, 2, 1, 110, '2021-01-04 00:00:00'),
	(6, 2, 1, 140, '2021-01-05 00:00:00'),
	(7, 2, 1, 190, '2021-01-06 00:00:00'),
	(8, 3, 1, 170, '2021-01-01 00:00:00'),
	(9, 3, 1, 120, '2021-01-02 00:00:00'),
	(10, 3, 1, 130, '2021-01-03 00:00:00'),
	(11, 1, 2, 130, '2021-01-03 00:00:00'),
	(12, 2, 2, 130, '2021-01-03 00:00:00'),
	(13, 3, 2, 125, '2021-01-03 00:00:00'),
	(14, 1, 2, 110, '2021-01-05 00:00:00'),
	(15, 1, 2, 100, '2021-01-01 00:00:00'),
	(16, 2, 2, 120, '2021-01-01 00:00:00'),
	(17, 3, 2, 120, '2021-01-01 00:00:00'),
	(18, 1, 4, 100, '2021-01-01 00:00:00'),
	(19, 1, 5, 180, '2021-01-02 00:00:00'),
	(20, 1, 6, 150, '2021-01-03 00:00:00'),
	(21, 1, 7, 110, '2021-01-04 00:00:00'),
	(22, 1, 8, 170, '2021-01-04 00:00:00'),
	(23, 1, 9, 188, '2021-01-04 00:00:00'),
	(24, 1, 10, 145, '2021-01-04 00:00:00'),
	(25, 2, 4, 77, '2021-01-01 00:00:00'),
	(26, 2, 5, 190, '2021-01-02 00:00:00'),
	(27, 2, 6, 133, '2021-01-03 00:00:00'),
	(28, 2, 7, 140, '2021-01-04 00:00:00'),
	(29, 2, 8, 140, '2021-01-04 00:00:00'),
	(30, 2, 9, 148, '2021-01-04 00:00:00'),
	(31, 2, 10, 125, '2021-01-04 00:00:00'),
	(32, 3, 4, 97, '2021-01-01 00:00:00'),
	(33, 3, 5, 120, '2021-01-02 00:00:00'),
	(34, 3, 6, 173, '2021-01-03 00:00:00'),
	(35, 3, 7, 160, '2021-01-04 00:00:00'),
	(36, 3, 8, 140, '2021-01-04 00:00:00'),
	(37, 3, 9, 198, '2021-01-04 00:00:00'),
	(38, 3, 10, 165, '2021-01-04 00:00:00');

-- Copiando estrutura para tabela db_tecnofit.user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela db_tecnofit.user: ~3 rows (aproximadamente)
DELETE FROM `user`;
INSERT INTO `user` (`id`, `name`) VALUES
	(1, 'Joao'),
	(2, 'Jose'),
	(3, 'Paulo');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
