-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 13 Mars 2019 à 09:05
-- Version du serveur :  5.6.16
-- Version de PHP :  5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `anciens_etudiants`
--

-- --------------------------------------------------------

--
-- Structure de la table `annuaire`
--

CREATE TABLE IF NOT EXISTS `annuaire` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `mail` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `annuaire`
--

INSERT INTO `annuaire` (`id`, `nom`, `prenom`, `mail`) VALUES
(4, 'nait belkacem', 'driss', 'driss.naitbelkacem@gmail.com\r'),
(5, 'vinc', 'maxou', 'maxiimus83@gmail.com\r');

-- --------------------------------------------------------

--
-- Structure de la table `info`
--

CREATE TABLE IF NOT EXISTS `info` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `promotion` varchar(60) NOT NULL,
  `formation` varchar(60) NOT NULL,
  `lieu_poursuite` varchar(60) DEFAULT NULL,
  `formation_poursuite` varchar(60) DEFAULT NULL,
  `type_poursuite` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `info`
--

INSERT INTO `info` (`id`, `promotion`, `formation`, `lieu_poursuite`, `formation_poursuite`, `type_poursuite`) VALUES
(1, '2019', 'INFO', 'dzad / dzadzad', 'Ecole d''ingenieur', 'initiale'),
(4, '2019', 'INFO', NULL, NULL, NULL),
(5, '2019', 'INFO', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE IF NOT EXISTS `utilisateur` (
  `login` varchar(10) NOT NULL,
  `mdp` varchar(64) NOT NULL,
  `droit` varchar(10) NOT NULL,
  PRIMARY KEY (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`login`, `mdp`, `droit`) VALUES
('admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'admin'),
('max', '9baf3a40312f39849f46dad1040f2f039f1cffa1238c41e9db675315cfad39b6', 'user');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
