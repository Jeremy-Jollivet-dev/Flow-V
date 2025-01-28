-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 28 oct. 2024 à 17:32
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `flow`
--

-- --------------------------------------------------------

--
-- Structure de la table `commenter`
--

DROP TABLE IF EXISTS `commenter`;
CREATE TABLE IF NOT EXISTS `commenter` (
  `id` int NOT NULL AUTO_INCREMENT,
  `parcours_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `commentaire` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_AB751D0A6E38C0DB` (`parcours_id`),
  KEY `IDX_AB751D0AA76ED395` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `difficulte`
--

DROP TABLE IF EXISTS `difficulte`;
CREATE TABLE IF NOT EXISTS `difficulte` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle_difficulte` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `difficulte`
--

INSERT INTO `difficulte` (`id`, `libelle_difficulte`) VALUES
(1, 'DEBUTANT'),
(2, 'INTERMEDIAIRE'),
(3, 'AVANCEE');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20241017163525', '2024-10-17 16:40:54', 1215);

-- --------------------------------------------------------

--
-- Structure de la table `parcours`
--

DROP TABLE IF EXISTS `parcours`;
CREATE TABLE IF NOT EXISTS `parcours` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type_de_parcours_id` int DEFAULT NULL,
  `difficulte_id` int DEFAULT NULL,
  `nom_parcours` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prive` tinyint(1) NOT NULL,
  `cree_par` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exclusif` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_99B1DEE34A858D66` (`type_de_parcours_id`),
  KEY `IDX_99B1DEE3E6357589` (`difficulte_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `pauser`
--

DROP TABLE IF EXISTS `pauser`;
CREATE TABLE IF NOT EXISTS `pauser` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pause_reprise_id` int DEFAULT NULL,
  `realiser_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B265FBCACDC3879D` (`pause_reprise_id`),
  KEY `IDX_B265FBCAAC274FA8` (`realiser_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `pause_reprise`
--

DROP TABLE IF EXISTS `pause_reprise`;
CREATE TABLE IF NOT EXISTS `pause_reprise` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date_debut_pause` datetime DEFAULT NULL,
  `date_fin_pause` datetime DEFAULT NULL,
  `lat` decimal(9,6) DEFAULT NULL,
  `lon` decimal(9,6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `points_map`
--

DROP TABLE IF EXISTS `points_map`;
CREATE TABLE IF NOT EXISTS `points_map` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type_de_points_id` int DEFAULT NULL,
  `parcours_id` int DEFAULT NULL,
  `lat` decimal(9,6) NOT NULL,
  `lon` decimal(9,6) NOT NULL,
  `details` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_53779626873E8F23` (`type_de_points_id`),
  KEY `IDX_537796266E38C0DB` (`parcours_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `realiser`
--

DROP TABLE IF EXISTS `realiser`;
CREATE TABLE IF NOT EXISTS `realiser` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `parcours_id` int DEFAULT NULL,
  `date_debut` datetime DEFAULT NULL,
  `date_fin` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7BAB8D07A76ED395` (`user_id`),
  KEY `IDX_7BAB8D076E38C0DB` (`parcours_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle_role` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id`, `libelle_role`) VALUES
(1, 'ROLE_AMATEUR'),
(2, 'ROLE_COMPETITOR'),
(3, 'ROLE_ROUTE_CREATOR'),
(4, 'ROLE_ADMIN');

-- --------------------------------------------------------

--
-- Structure de la table `type_de_parcours`
--

DROP TABLE IF EXISTS `type_de_parcours`;
CREATE TABLE IF NOT EXISTS `type_de_parcours` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle_parcours` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `type_de_parcours`
--

INSERT INTO `type_de_parcours` (`id`, `libelle_parcours`) VALUES
(1, 'ALLER-SIMPLE'),
(2, 'EN BOUCLE'),
(3, 'VTT');

-- --------------------------------------------------------

--
-- Structure de la table `type_de_points`
--

DROP TABLE IF EXISTS `type_de_points`;
CREATE TABLE IF NOT EXISTS `type_de_points` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle_type_point` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `type_de_points`
--

INSERT INTO `type_de_points` (`id`, `libelle_type_point`) VALUES
(1, 'DEPART'),
(2, 'ARRIVEE'),
(3, 'INTERMEDIAIRE');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role_id` int DEFAULT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pseudo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`),
  KEY `IDX_1483A5E9D60322AC` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `role_id`, `email`, `roles`, `password`, `pseudo`) VALUES
(7, 1, 'mathys@gmail.com', '[]', '$2y$13$AqP48Ykt5MwKkPzLksJ3TepefbF0hbcNsbbkdLY67NDpuaTqPEL1y', 'Mathys');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commenter`
--
ALTER TABLE `commenter`
  ADD CONSTRAINT `FK_AB751D0A6E38C0DB` FOREIGN KEY (`parcours_id`) REFERENCES `parcours` (`id`),
  ADD CONSTRAINT `FK_AB751D0AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `parcours`
--
ALTER TABLE `parcours`
  ADD CONSTRAINT `FK_99B1DEE34A858D66` FOREIGN KEY (`type_de_parcours_id`) REFERENCES `type_de_parcours` (`id`),
  ADD CONSTRAINT `FK_99B1DEE3E6357589` FOREIGN KEY (`difficulte_id`) REFERENCES `difficulte` (`id`);

--
-- Contraintes pour la table `pauser`
--
ALTER TABLE `pauser`
  ADD CONSTRAINT `FK_B265FBCAAC274FA8` FOREIGN KEY (`realiser_id`) REFERENCES `realiser` (`id`),
  ADD CONSTRAINT `FK_B265FBCACDC3879D` FOREIGN KEY (`pause_reprise_id`) REFERENCES `pause_reprise` (`id`);

--
-- Contraintes pour la table `points_map`
--
ALTER TABLE `points_map`
  ADD CONSTRAINT `FK_537796266E38C0DB` FOREIGN KEY (`parcours_id`) REFERENCES `parcours` (`id`),
  ADD CONSTRAINT `FK_53779626873E8F23` FOREIGN KEY (`type_de_points_id`) REFERENCES `type_de_points` (`id`);

--
-- Contraintes pour la table `realiser`
--
ALTER TABLE `realiser`
  ADD CONSTRAINT `FK_7BAB8D076E38C0DB` FOREIGN KEY (`parcours_id`) REFERENCES `parcours` (`id`),
  ADD CONSTRAINT `FK_7BAB8D07A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_1483A5E9D60322AC` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
