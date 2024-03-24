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


-- Listage de la structure de la base pour cinema_gino
CREATE DATABASE IF NOT EXISTS `cinema_gino` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `cinema_gino`;

-- Listage de la structure de table cinema_gino. acteur
CREATE TABLE IF NOT EXISTS `acteur` (
  `id_acteur` int NOT NULL AUTO_INCREMENT,
  `id_personne` int NOT NULL,
  PRIMARY KEY (`id_acteur`),
  KEY `id_personne` (`id_personne`),
  CONSTRAINT `FK_acteur_personne` FOREIGN KEY (`id_personne`) REFERENCES `personne` (`id_personne`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table cinema_gino.acteur : ~12 rows (environ)
INSERT INTO `acteur` (`id_acteur`, `id_personne`) VALUES
	(8, 1),
	(7, 2),
	(5, 3),
	(3, 4),
	(11, 5),
	(4, 6),
	(1, 7),
	(6, 9),
	(10, 10),
	(9, 11),
	(2, 14),
	(12, 15);

-- Listage de la structure de table cinema_gino. casting
CREATE TABLE IF NOT EXISTS `casting` (
  `id_film` int NOT NULL,
  `id_acteur` int NOT NULL,
  `id_role` int NOT NULL,
  KEY `id_film_id_acteur_id_role` (`id_film`,`id_acteur`,`id_role`),
  KEY `FK_casting_acteur` (`id_acteur`),
  KEY `FK_casting_role` (`id_role`),
  CONSTRAINT `FK_casting_acteur` FOREIGN KEY (`id_acteur`) REFERENCES `acteur` (`id_acteur`),
  CONSTRAINT `FK_casting_film` FOREIGN KEY (`id_film`) REFERENCES `film` (`id_film`),
  CONSTRAINT `FK_casting_role` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table cinema_gino.casting : ~4 rows (environ)
INSERT INTO `casting` (`id_film`, `id_acteur`, `id_role`) VALUES
	(2, 6, 1),
	(3, 7, 2);

-- Listage de la structure de table cinema_gino. film
CREATE TABLE IF NOT EXISTS `film` (
  `id_film` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `parution` datetime NOT NULL,
  `duree` int NOT NULL,
  `synopsis` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `note` float NOT NULL DEFAULT '0',
  `affiche` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '',
  `id_realisateur` int NOT NULL,
  PRIMARY KEY (`id_film`),
  KEY `id_realisateur` (`id_realisateur`),
  CONSTRAINT `FK_film_realisateur` FOREIGN KEY (`id_realisateur`) REFERENCES `realisateur` (`id_realisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table cinema_gino.film : ~6 rows (environ)
INSERT INTO `film` (`id_film`, `titre`, `parution`, `duree`, `synopsis`, `note`, `affiche`, `id_realisateur`) VALUES
	(1, 'Dune', '2021-09-15 00:00:00', 155, 'L\'histoire de Paul Atreides, jeune homme aussi doué que brillant, voué à connaître un destin hors du commun qui le dépasse totalement. Car s\'il veut préserver l\'avenir de sa famille et de son peuple, il devra se rendre sur la planète la plus dangereuse de l\'univers – la seule à même de fournir la ressource la plus précieuse au monde, capable de décupler la puissance de l\'humanité. Tandis que des forces maléfiques se disputent le contrôle de cette planète, seuls ceux qui parviennent à dominer leur peur pourront survivre…', 4.2, 'public\\img\\affiches\\dune.webp', 3),
	(2, 'Django', '2013-01-16 00:00:00', 165, 'Un esclave noir est affranchi par un chasseur de primes. Le moment est venu de sauver son épouse d\'un riche propriétaire de plantation du Mississipi.', 4.5, 'public\\img\\affiches\\django.webp', 2),
	(3, 'The Revenant', '2015-12-25 00:00:00', 156, 'Dans les années 1820, un trappeur est laissé pour mort par ses camarades après une attaque d\'ours. Il survit et se lance dans une quête de vengeance.', 4.3, 'public\\img\\affiches\\the_revenant.webp', 3),
	(4, 'Mad Max', '2015-05-15 00:00:00', 120, 'Dans un monde post-apocalyptique, Max se joint à une guerrière pour échapper à un tyran et sa horde de disciples fanatiques.', 4.4, 'public\\img\\affiches\\mad_max.webp', 1),
	(5, 'Interstellar', '2014-11-05 00:00:00', 169, 'Dans un futur où la Terre est devenue inhabitable, un groupe d\'explorateurs part à la recherche d\'une nouvelle planète habitable pour l\'humanité.', 4.5, 'public\\img\\affiches\\interstellar.webp', 1),
	(6, 'Inception', '2010-07-16 00:00:00', 148, 'Un voleur spécialisé dans l\'extraction d\'informations du subconscient pendant les rêves est chargé d\'implanter une idée dans l\'esprit d\'un PDG.', 4.6, 'public\\img\\affiches\\inception.webp', 1);

-- Listage de la structure de table cinema_gino. genre
CREATE TABLE IF NOT EXISTS `genre` (
  `id_genre` int NOT NULL AUTO_INCREMENT,
  `nom_genre` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id_genre`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table cinema_gino.genre : ~6 rows (environ)
INSERT INTO `genre` (`id_genre`, `nom_genre`) VALUES
	(1, 'Western'),
	(2, 'Thriller'),
	(3, 'Science-Fiction'),
	(4, 'Aventure'),
	(5, 'Action'),
	(6, 'Drame');

-- Listage de la structure de table cinema_gino. genre_film
CREATE TABLE IF NOT EXISTS `genre_film` (
  `id_film` int NOT NULL,
  `id_genre` int NOT NULL,
  KEY `id_film_id_genre` (`id_film`,`id_genre`),
  KEY `FK_genre_film_genre` (`id_genre`),
  CONSTRAINT `FK_genre_film_film` FOREIGN KEY (`id_film`) REFERENCES `film` (`id_film`),
  CONSTRAINT `FK_genre_film_genre` FOREIGN KEY (`id_genre`) REFERENCES `genre` (`id_genre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table cinema_gino.genre_film : ~22 rows (environ)
INSERT INTO `genre_film` (`id_film`, `id_genre`) VALUES
	(1, 1),
	(2, 1),
	(2, 5),
	(3, 5),
	(4, 5),
	(5, 3),
	(5, 4),
	(6, 3);

-- Listage de la structure de table cinema_gino. personne
CREATE TABLE IF NOT EXISTS `personne` (
  `id_personne` int NOT NULL AUTO_INCREMENT,
  `prenom` varchar(50) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `sexe` varchar(50) NOT NULL,
  `dateNaissance` date NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '',
  PRIMARY KEY (`id_personne`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table cinema_gino.personne : ~14 rows (environ)
INSERT INTO `personne` (`id_personne`, `prenom`, `nom`, `sexe`, `dateNaissance`, `photo`) VALUES
	(1, 'Quentin', 'Tarantino', 'Homme', '1963-03-27', 'public\\img\\personnes\\tarantino.webp'),
	(2, 'Leonardo', 'DiCaprio', 'Homme', '1974-11-11', 'public\\img\\personnes\\dicaprio.webp'),
	(3, 'Joseph', 'Gordon-Levitt', 'Homme', '1981-02-17', 'public\\img\\personnes\\gordon-levitt.webp'),
	(4, 'Ellen', 'Page', 'Femme', '1987-02-21', 'public\\img\\personnes\\page.webp'),
	(5, 'Tom', 'Hardy', 'Homme', '1977-09-15', 'public\\img\\personnes\\hardy.webp'),
	(6, 'Jamie', 'Foxx', 'Homme', '1967-12-13', 'public\\img\\personnes\\jamie.webp'),
	(7, 'Christoph', 'Waltz', 'Homme', '1956-10-04', 'public\\img\\personnes\\waltz.webp'),
	(9, 'Kerry', 'Washington', 'Femme', '1977-01-31', 'public\\img\\personnes\\washington.webp'),
	(10, 'Timothée', 'Chalamet', 'Homme', '1995-12-27', 'public\\img\\personnes\\chalamet.webp'),
	(11, 'Rebecca', 'Ferguson', 'Femme', '1983-10-19', 'public\\img\\personnes\\ferguson.webp'),
	(14, 'Domhnall', 'Gleeson', 'Homme', '1983-05-12', 'public\\img\\personnes\\gleeson.webp'),
	(15, 'Will', 'Poulter', 'Homme', '1993-01-28', 'public\\img\\personnes\\poulter.webp'),
	(16, 'Christopher', 'Nolan', 'Homme', '1970-07-30', 'public\\img\\personnes\\nolan.webp'),
	(17, 'Denis', 'Villeneuve', 'Homme', '1967-10-03', 'public\\img\\personnes\\villeneuve.webp');

-- Listage de la structure de table cinema_gino. realisateur
CREATE TABLE IF NOT EXISTS `realisateur` (
  `id_realisateur` int NOT NULL AUTO_INCREMENT,
  `id_personne` int NOT NULL,
  PRIMARY KEY (`id_realisateur`),
  KEY `id_personne` (`id_personne`),
  CONSTRAINT `FK_realisateur_personne` FOREIGN KEY (`id_personne`) REFERENCES `personne` (`id_personne`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table cinema_gino.realisateur : ~3 rows (environ)
INSERT INTO `realisateur` (`id_realisateur`, `id_personne`) VALUES
	(2, 1),
	(1, 16),
	(3, 17);

-- Listage de la structure de table cinema_gino. role
CREATE TABLE IF NOT EXISTS `role` (
  `id_role` int NOT NULL AUTO_INCREMENT,
  `role_personnage` varchar(50) NOT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table cinema_gino.role : ~2 rows (environ)
INSERT INTO `role` (`id_role`, `role_personnage`) VALUES
	(1, 'Django'),
	(2, 'Hugh Glass');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
