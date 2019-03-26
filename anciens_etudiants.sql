-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mar. 26 mars 2019 à 16:15
-- Version du serveur :  10.1.36-MariaDB
-- Version de PHP :  7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `anciens_etudiants`
--

-- --------------------------------------------------------

--
-- Structure de la table `annuaire`
--

CREATE TABLE `annuaire` (
  `id` int(4) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `mail` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `annuaire`
--

INSERT INTO `annuaire` (`id`, `nom`, `prenom`, `mail`) VALUES
(170, 'VINCENT', 'Maxime', 'maxs.vincent78@gmail.com'),
(171, 'NAIT BELKACEM', 'Driss', 'driss@gmail.com'),
(172, 'HAMEL', 'Hugo', 'HH@gmail.com'),
(173, 'MOUZOURI', 'Ilhame', 'Mouzmouz@gmail.com'),
(174, 'DUPONT', 'Jean', 'DD@glaposte.net'),
(176, 'Dutheil', 'Romain', 'rominou@gmail.com'),
(177, 'COUSIN', 'Rebecca', 'reb@gmail.com'),
(178, 'DUPONT', 'Pierre', 'dd@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `info`
--

CREATE TABLE `info` (
  `id` int(4) NOT NULL,
  `promotion` varchar(60) DEFAULT NULL,
  `formation` varchar(60) DEFAULT NULL,
  `lieu_poursuite` varchar(60) DEFAULT NULL,
  `formation_poursuite` varchar(60) DEFAULT NULL,
  `type_poursuite` varchar(60) DEFAULT NULL,
  `etablissement_poursuite` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `info`
--

INSERT INTO `info` (`id`, `promotion`, `formation`, `lieu_poursuite`, `formation_poursuite`, `type_poursuite`, `etablissement_poursuite`) VALUES
(170, '2019', 'INFO', NULL, NULL, NULL, NULL),
(171, '2019', 'INFO', NULL, NULL, NULL, NULL),
(172, '2019', 'INFO', NULL, NULL, NULL, NULL),
(173, '2019', 'INFO', NULL, NULL, NULL, NULL),
(174, '2015', 'INFO', 'VELIZY', 'Ecole d\'ingenieur', 'initiale', 'ISTY'),
(175, '2015', 'INFO', NULL, 'Aucune', NULL, NULL),
(176, '2017', 'INFO', 'ORSAY', 'Miage', 'alternance', 'Fac ORSAY'),
(177, '2015', 'INFO', NULL, NULL, NULL, NULL),
(178, '2015', 'INFO', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `login` varchar(10) NOT NULL,
  `mdp` varchar(64) NOT NULL,
  `droit` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`login`, `mdp`, `droit`) VALUES
('admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'admin'),
('max', '9baf3a40312f39849f46dad1040f2f039f1cffa1238c41e9db675315cfad39b6', 'user');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `annuaire`
--
ALTER TABLE `annuaire`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Index pour la table `info`
--
ALTER TABLE `info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `annuaire`
--
ALTER TABLE `annuaire`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=179;

--
-- AUTO_INCREMENT pour la table `info`
--
ALTER TABLE `info`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=179;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
