-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour symfonysession
CREATE DATABASE IF NOT EXISTS `symfonysession` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `symfonysession`;

-- Listage de la structure de table symfonysession. category
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table symfonysession.category : ~5 rows (environ)
INSERT INTO `category` (`id`, `name`) VALUES
	(1, 'Infographie'),
	(2, 'Bureautique'),
	(3, 'Back-End'),
	(5, 'Projet'),
	(6, 'Front-End'),
	(7, 'Démarche');

-- Listage de la structure de table symfonysession. doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Listage des données de la table symfonysession.doctrine_migration_versions : ~0 rows (environ)
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20230927154727', '2023-09-27 15:47:59', 1946);

-- Listage de la structure de table symfonysession. messenger_messages
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table symfonysession.messenger_messages : ~0 rows (environ)

-- Listage de la structure de table symfonysession. module
CREATE TABLE IF NOT EXISTS `module` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C24262812469DE2` (`category_id`),
  CONSTRAINT `FK_C24262812469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table symfonysession.module : ~8 rows (environ)
INSERT INTO `module` (`id`, `category_id`, `name`) VALUES
	(1, 2, 'Word'),
	(3, 3, 'PHP'),
	(4, 2, 'Excel'),
	(5, 6, 'JavaScript'),
	(6, 3, 'SQL'),
	(7, 6, 'FIGMA'),
	(8, 1, 'Photoshop'),
	(9, 7, 'Recherche de Stage'),
	(10, 7, 'Rédiger un CV'),
	(11, 3, 'Symfony'),
	(12, 3, 'Python'),
	(13, 3, 'Java'),
	(14, 6, 'Bootstrap'),
	(15, 1, 'Adobe XD');

-- Listage de la structure de table symfonysession. program
CREATE TABLE IF NOT EXISTS `program` (
  `id` int NOT NULL AUTO_INCREMENT,
  `session_id` int NOT NULL,
  `modules_id` int NOT NULL,
  `number_of_days` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_92ED7784613FECDF` (`session_id`),
  KEY `IDX_92ED778460D6DC42` (`modules_id`),
  CONSTRAINT `FK_92ED778460D6DC42` FOREIGN KEY (`modules_id`) REFERENCES `module` (`id`),
  CONSTRAINT `FK_92ED7784613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table symfonysession.program : ~4 rows (environ)
INSERT INTO `program` (`id`, `session_id`, `modules_id`, `number_of_days`) VALUES
	(3, 2, 3, 8),
	(4, 4, 3, 5),
	(5, 4, 1, 3),
	(18, 9, 6, 5),
	(19, 9, 12, 11),
	(20, 9, 10, 1),
	(21, 9, 9, 15);

-- Listage de la structure de table symfonysession. session
CREATE TABLE IF NOT EXISTS `session` (
  `id` int NOT NULL AUTO_INCREMENT,
  `training_id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `number_of_places` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D044D5D4BEFD98D1` (`training_id`),
  CONSTRAINT `FK_D044D5D4BEFD98D1` FOREIGN KEY (`training_id`) REFERENCES `training` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table symfonysession.session : ~2 rows (environ)
INSERT INTO `session` (`id`, `training_id`, `name`, `start_date`, `end_date`, `number_of_places`) VALUES
	(2, 1, 'Mulhouse DWMW5', '2023-05-12 00:00:00', '2023-05-20 00:00:00', 15),
	(4, 1, 'Metz Général', '2023-09-21 00:00:00', '2023-10-11 00:00:00', 10),
	(9, 7, 'Data science MULHOUSE DS1', '2023-10-17 00:00:00', '2023-10-24 00:00:00', 13);

-- Listage de la structure de table symfonysession. session_student
CREATE TABLE IF NOT EXISTS `session_student` (
  `session_id` int NOT NULL,
  `student_id` int NOT NULL,
  PRIMARY KEY (`session_id`,`student_id`),
  KEY `IDX_A5FB2D69613FECDF` (`session_id`),
  KEY `IDX_A5FB2D69CB944F1A` (`student_id`),
  CONSTRAINT `FK_A5FB2D69613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_A5FB2D69CB944F1A` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table symfonysession.session_student : ~1 rows (environ)
INSERT INTO `session_student` (`session_id`, `student_id`) VALUES
	(2, 1),
	(9, 3),
	(9, 4),
	(9, 6),
	(9, 10),
	(9, 16),
	(9, 20);

-- Listage de la structure de table symfonysession. student
CREATE TABLE IF NOT EXISTS `student` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lastname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_date` date NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table symfonysession.student : ~21 rows (environ)
INSERT INTO `student` (`id`, `lastname`, `firstname`, `birth_date`, `email`, `phone_number`, `street`, `city`, `zip_code`) VALUES
	(1, 'Dubois', 'Pierre', '2000-08-29', 'dubois.pierre@session.com', '0712202556', '5 rue des fleurs', 'STRASBOURG', '67000'),
	(3, 'Doe', 'John', '1995-05-18', 'doe.john@session.com', '0520351475', '2 rue des étoiles', 'Paris', '75018'),
	(4, 'Smith', 'Emily', '1990-09-25', 'smith.emily@session.com', '0712345678', '123 Main Street', 'New York', '10001'),
	(5, 'Johnson', 'Michael', '1988-03-12', 'johnson.michael@session.com', '0432109876', '456 Elm Avenue', 'Los Angeles', '90002'),
	(6, 'Brown', 'Sarah', '1992-11-30', 'brown.sarah@session.com', '0912345678', '789 Oak Lane', 'Chicago', '60603'),
	(7, 'Williams', 'David', '1997-07-08', 'williams.david@session.com', '0611112222', '101 Pine Road', 'Houston', '77001'),
	(8, 'Jones', 'Jessica', '1993-02-15', 'jones.jessica@session.com', '0755555555', '222 Cedar Street', 'Phoenix', '85001'),
	(9, 'Anderson', 'Jennifer', '1985-12-01', 'anderson.jennifer@session.com', '0322222222', '333 Birch Drive', 'San Antonio', '78201'),
	(10, 'Martinez', 'Robert', '1990-04-27', 'martinez.robert@session.com', '0543210987', '444 Maple Lane', 'San Diego', '92101'),
	(11, 'Davis', 'Michelle', '1994-06-14', 'davis.michelle@session.com', '0987654321', '555 Oak Street', 'Philadelphia', '19101'),
	(12, 'Garcia', 'Christopher', '1989-08-03', 'garcia.christopher@session.com', '0666666666', '666 Pine Road', 'San Francisco', '94101'),
	(13, 'Rodriguez', 'Linda', '1996-01-20', 'rodriguez.linda@session.com', '0865432109', '777 Elm Avenue', 'Seattle', '98101'),
	(14, 'Wilson', 'James', '1987-10-10', 'wilson.james@session.com', '0777777777', '888 Cedar Street', 'Miami', '33101'),
	(15, 'Smith', 'Amanda', '1991-09-05', 'smith.amanda@session.com', '0999999999', '999 Oak Lane', 'Dallas', '75201'),
	(16, 'Johnson', 'Matthew', '1998-03-28', 'johnson.matthew@session.com', '0355555555', '111 Pine Road', 'Denver', '80201'),
	(17, 'Brown', 'Karen', '1992-04-15', 'brown.karen@session.com', '0123456789', '444 Birch Drive', 'Atlanta', '30301'),
	(18, 'Williams', 'Daniel', '1995-12-09', 'williams.daniel@session.com', '0577777777', '555 Maple Lane', 'Boston', '02201'),
	(19, 'Jones', 'Lisa', '1986-06-22', 'jones.lisa@session.com', '0412345678', '666 Oak Street', 'Austin', '73301'),
	(20, 'Taylor', 'William', '1984-07-07', 'taylor.william@session.com', '0101010101', '777 Cedar Street', 'Portland', '97201'),
	(21, 'Miller', 'Jennifer', '1993-05-18', 'miller.jennifer@session.com', '0876543210', '888 Elm Avenue', 'Detroit', '48201'),
	(22, 'Davis', 'Daniel', '1988-09-30', 'davis.daniel@session.com', '0444444444', '123 Oak Lane', 'Raleigh', '27601');

-- Listage de la structure de table symfonysession. training
CREATE TABLE IF NOT EXISTS `training` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table symfonysession.training : ~2 rows (environ)
INSERT INTO `training` (`id`, `name`) VALUES
	(1, 'Développeur Web / Mobile Web'),
	(5, 'Front-End Developper'),
	(6, 'Designer'),
	(7, 'Data science'),
	(8, 'Cyber security'),
	(9, 'Secretary');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
