-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Mer 16 Octobre 2013 à 12:45
-- Version du serveur: 5.5.8
-- Version de PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `interne_actiane`
--

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `couleur` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `interne` tinyint(4) NOT NULL DEFAULT '0',
  `secteur` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `siret` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tva` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entite` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `siege` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `facturation` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contactp` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telp` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mailp` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contacts` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tels` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mails` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contactc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mailc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nom` (`nom`),
  KEY `interne` (`interne`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Contenu de la table `client`
--

INSERT INTO `client` (`id`, `nom`, `couleur`, `interne`, `secteur`, `siret`, `tva`, `entite`, `siege`, `facturation`, `contactp`, `telp`, `mailp`, `contacts`, `tels`, `mails`, `contactc`, `telc`, `mailc`) VALUES
(2, 'Signal', '#0080ff', 0, 'SantÃ©', '543-670-663-00777', 'FR66445854629', 'Blancheur', '56 rue des abricots - 77000 Seine et Marne', '64 rue des chats perchÃ©s ', 'Adrien Mask', '01 42 56 78 29', 'a.mask@gmail.com', 'Adrien Mask', '01 42 56 78 29', 'a.mask@gmail.com', 'Adrien Mask', '01 42 56 78 29', 'a.mask@gmail.com'),
(3, 'HSBC France', '#ff0000', 0, 'Banque', '543-670-663-00777', 'FR66445854629', 'Private Bank', '103 Avenue des Champs ElysÃ©es â€“ 75008 Paris', '24 Rue du CafÃ© â€“ 92345 Nanterre', 'Adrien Mask', '01 42 56 78 29', 'mdupont@hsbc.fr', 'Patricia Larue', '01 42 56 78 29', 'plarue@hsbc.fr', 'Jocelyne Cerise', '01 42 56 78 29', 'jcerise@hsbc.fr'),
(4, 'Actiane', '#00ffff', 0, 'Commerce', '543-670-663-00777', 'FR66445854629', 'Consulting', '34 rue de la Victoire - 75001 Paris', '34 rue de la Victoire - 75001 Paris', 'FrÃ©dÃ©ric Douchet', '01 42 56 78 29', 'frederic.douchet@actiane.com', 'FrÃ©dÃ©ric Douchet', '01 42 56 78 29', 'frederic.douchet@actiane.com', 'FrÃ©dÃ©ric Douchet', '01 42 56 78 29', 'frederic.douchet@actiane.com'),
(5, 'Aareon France', '#EF8525', 0, 'Editeur logiciel', NULL, NULL, NULL, '9 rue Jeanne Braconnier - Meudon', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `collaboration`
--

DROP TABLE IF EXISTS `collaboration`;
CREATE TABLE IF NOT EXISTS `collaboration` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idProjet` int(10) unsigned NOT NULL,
  `idIdentite` int(10) unsigned NOT NULL,
  `dateDebut` date NOT NULL,
  `dateFin` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idClient_2` (`idProjet`,`idIdentite`,`dateDebut`),
  KEY `idClient` (`idProjet`),
  KEY `idIdentite` (`idIdentite`),
  KEY `dateDebut` (`dateDebut`,`dateFin`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Contenu de la table `collaboration`
--

INSERT INTO `collaboration` (`id`, `idProjet`, `idIdentite`, `dateDebut`, `dateFin`) VALUES
(2, 2, 4, '2012-10-01', NULL),
(3, 3, 4, '2013-06-01', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `conges`
--

DROP TABLE IF EXISTS `conges`;
CREATE TABLE IF NOT EXISTS `conges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idType` int(10) unsigned NOT NULL,
  `idIdentite` int(10) unsigned NOT NULL,
  `jour` date NOT NULL,
  `matin` int(11) NOT NULL,
  `apresMidi` int(11) NOT NULL,
  `validation` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Contenu de la table `conges`
--

INSERT INTO `conges` (`id`, `idType`, `idIdentite`, `jour`, `matin`, `apresMidi`, `validation`) VALUES
(4, 1, 4, '2013-10-03', 325, 325, 1),
(5, 3, 4, '2013-09-04', 240, 0, 1),
(6, 2, 4, '2013-09-13', 0, 300, 1);

-- --------------------------------------------------------

--
-- Structure de la table `identite`
--

DROP TABLE IF EXISTS `identite`;
CREATE TABLE IF NOT EXISTS `identite` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idUser` int(11) unsigned NOT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `acronyme` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dateNaissance` date NOT NULL,
  `lieuNaissance` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idProfil` int(11) NOT NULL,
  `dateEntree` date NOT NULL,
  `intitule` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `statut` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `coefficient` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `competencesf` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `competencest` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `equipe` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `responsable` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tjm` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `acronyme` (`acronyme`),
  KEY `mail` (`mail`),
  KEY `idUser` (`idUser`),
  KEY `idProfil` (`idProfil`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Contenu de la table `identite`
--

INSERT INTO `identite` (`id`, `idUser`, `nom`, `prenom`, `acronyme`, `mail`, `adresse`, `dateNaissance`, `lieuNaissance`, `telephone`, `idProfil`, `dateEntree`, `intitule`, `statut`, `position`, `coefficient`, `competencesf`, `competencest`, `equipe`, `responsable`, `tjm`) VALUES
(1, 1, 'Khemri', 'Samya', 'SKH', 'samya.khemri@actiane.com', '', '1994-07-19', 'Melun', '', 1, '0000-00-00', '', '', '', '', '', '', '', '', 0),
(2, 2, 'Douchet', 'Frederic', 'FDO', 'frederic.douchet@actiane.com', '', '0000-00-00', '', NULL, 2, '0000-00-00', '', '', '', '', '', '', '', '', 0),
(3, 3, 'Bouaiss', 'Rachida', 'RBO', 'rachida.bouaiss@actiane.com', '', '0000-00-00', '', NULL, 2, '0000-00-00', '', '', '', '', '', '', '', '', 0),
(4, 4, 'Giraud', 'Nicolas', 'NGI', 'nicolas.giraud@actiane.com', '', '0000-00-00', '', NULL, 1, '0000-00-00', '', '', '', '', '', '', '', '', 0);

-- --------------------------------------------------------

--
-- Structure de la table `journeecollab`
--

DROP TABLE IF EXISTS `journeecollab`;
CREATE TABLE IF NOT EXISTS `journeecollab` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idCollaboration` int(10) unsigned NOT NULL,
  `jour` date NOT NULL,
  `matin` int(11) NOT NULL,
  `apresMidi` int(11) NOT NULL,
  `validation` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idCollaboration` (`idCollaboration`,`jour`),
  KEY `jour` (`jour`),
  KEY `idCollaboration_2` (`idCollaboration`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=88 ;

--
-- Contenu de la table `journeecollab`
--

INSERT INTO `journeecollab` (`id`, `idCollaboration`, `jour`, `matin`, `apresMidi`, `validation`) VALUES
(1, 2, '2013-10-02', 120, 330, 1),
(2, 2, '2013-10-01', 0, 0, 0),
(3, 2, '2013-10-03', 0, 0, 0),
(4, 2, '2013-10-04', 0, 0, 0),
(5, 2, '2013-10-07', 0, 0, 0),
(6, 2, '2013-10-08', 0, 0, 0),
(7, 2, '2013-10-09', 0, 0, 0),
(8, 2, '2013-10-10', 0, 0, 0),
(9, 2, '2013-10-11', 0, 0, 0),
(10, 2, '2013-10-14', 0, 0, 0),
(11, 2, '2013-10-15', 0, 0, 0),
(12, 2, '2013-10-16', 0, 0, 0),
(13, 2, '2013-10-17', 0, 0, 0),
(14, 2, '2013-10-18', 0, 0, 0),
(15, 2, '2013-10-21', 0, 0, 0),
(16, 2, '2013-10-22', 0, 0, 0),
(17, 2, '2013-10-23', 0, 0, 0),
(18, 2, '2013-10-24', 0, 0, 0),
(19, 2, '2013-10-25', 0, 0, 0),
(20, 2, '2013-10-28', 0, 0, 0),
(21, 2, '2013-10-29', 0, 0, 0),
(22, 2, '2013-10-30', 0, 0, 0),
(23, 2, '2013-10-31', 0, 0, 0),
(24, 3, '2013-10-01', 0, 0, 0),
(25, 3, '2013-10-03', 0, 0, 0),
(26, 3, '2013-10-04', 0, 0, 0),
(27, 3, '2013-10-07', 0, 0, 0),
(28, 3, '2013-10-08', 0, 0, 0),
(29, 3, '2013-10-09', 0, 0, 0),
(30, 3, '2013-10-10', 0, 0, 0),
(31, 3, '2013-10-11', 0, 0, 0),
(32, 3, '2013-10-14', 0, 0, 0),
(33, 3, '2013-10-15', 0, 0, 0),
(34, 3, '2013-10-16', 0, 0, 0),
(35, 3, '2013-10-17', 0, 0, 0),
(36, 3, '2013-10-18', 0, 0, 0),
(37, 3, '2013-10-21', 0, 0, 0),
(38, 3, '2013-10-22', 0, 0, 0),
(39, 3, '2013-10-23', 0, 0, 0),
(40, 3, '2013-10-24', 0, 0, 0),
(41, 3, '2013-10-25', 0, 0, 0),
(42, 3, '2013-10-28', 0, 0, 0),
(43, 3, '2013-10-29', 0, 0, 0),
(44, 3, '2013-10-30', 0, 0, 0),
(45, 3, '2013-10-31', 0, 0, 0),
(46, 2, '2013-09-02', 120, 390, 0),
(47, 2, '2013-09-03', 120, 390, 0),
(48, 2, '2013-09-04', 0, 240, 0),
(49, 2, '2013-09-05', 180, 330, 0),
(50, 2, '2013-09-06', 180, 330, 0),
(51, 2, '2013-09-09', 120, 390, 0),
(52, 2, '2013-09-10', 120, 390, 0),
(53, 2, '2013-09-11', 120, 390, 0),
(54, 2, '2013-09-12', 150, 360, 0),
(55, 2, '2013-09-13', 210, 0, 0),
(56, 2, '2013-09-16', 150, 360, 0),
(57, 2, '2013-09-17', 120, 300, 0),
(58, 2, '2013-09-18', 180, 300, 0),
(59, 2, '2013-09-19', 150, 360, 0),
(60, 2, '2013-09-20', 240, 300, 0),
(61, 2, '2013-09-23', 150, 330, 0),
(62, 2, '2013-09-24', 90, 360, 0),
(63, 2, '2013-09-25', 180, 300, 0),
(64, 2, '2013-09-26', 180, 240, 0),
(65, 2, '2013-09-27', 210, 240, 0),
(66, 2, '2013-09-30', 300, 120, 0),
(67, 3, '2013-09-02', 120, 390, 1),
(68, 3, '2013-09-03', 120, 390, 1),
(69, 3, '2013-09-04', 0, 240, 1),
(70, 3, '2013-09-05', 180, 330, 1),
(71, 3, '2013-09-06', 180, 330, 1),
(72, 3, '2013-09-09', 120, 390, 1),
(73, 3, '2013-09-10', 120, 390, 1),
(74, 3, '2013-09-11', 120, 390, 1),
(75, 3, '2013-09-12', 150, 360, 1),
(76, 3, '2013-09-13', 210, 0, 1),
(77, 3, '2013-09-16', 150, 360, 1),
(78, 3, '2013-09-17', 120, 300, 1),
(79, 3, '2013-09-18', 180, 300, 1),
(80, 3, '2013-09-19', 150, 360, 1),
(81, 3, '2013-09-20', 240, 300, 1),
(82, 3, '2013-09-23', 150, 330, 1),
(83, 3, '2013-09-24', 90, 360, 1),
(84, 3, '2013-09-25', 180, 300, 1),
(85, 3, '2013-09-26', 180, 240, 1),
(86, 3, '2013-09-27', 210, 240, 1),
(87, 3, '2013-09-30', 300, 120, 1);

-- --------------------------------------------------------

--
-- Structure de la table `mois_activite`
--

DROP TABLE IF EXISTS `mois_activite`;
CREATE TABLE IF NOT EXISTS `mois_activite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idIdentite` int(11) NOT NULL,
  `mois` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `validation` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Contenu de la table `mois_activite`
--


-- --------------------------------------------------------

--
-- Structure de la table `profil`
--

DROP TABLE IF EXISTS `profil`;
CREATE TABLE IF NOT EXISTS `profil` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `libelle` (`libelle`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Contenu de la table `profil`
--

INSERT INTO `profil` (`id`, `code`, `libelle`) VALUES
(1, '#FF0000', 'Collaborateur'),
(2, '#00E600', 'Administrateur');

-- --------------------------------------------------------

--
-- Structure de la table `projet`
--

DROP TABLE IF EXISTS `projet`;
CREATE TABLE IF NOT EXISTS `projet` (
  `idProjet` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idClient` int(11) NOT NULL,
  `nomProjet` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `referent` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `format` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `numContrat` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `duree` int(11) NOT NULL,
  `debut` date NOT NULL,
  `fin` date NOT NULL,
  `responsable` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `collaborateurs` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `budget` int(11) NOT NULL,
  `delai` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idProjet`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Contenu de la table `projet`
--

INSERT INTO `projet` (`idProjet`, `idClient`, `nomProjet`, `referent`, `format`, `numContrat`, `duree`, `debut`, `fin`, `responsable`, `collaborateurs`, `budget`, `delai`) VALUES
(1, 3, 'Unisson 2', 'Germaine Dulac', 'Regie', '123-GDF-56-XTD45', 120, '2013-02-13', '2013-12-13', 'FrÃ©dÃ©ric Douchet', 'FDO', 24, 0),
(2, 5, 'Création CMS', 'Hervé Cliquet', 'Clientèle', 'PROD\\40000796', 21, '2012-10-01', '2014-07-01', 'Yves Le Meur', 'FDO', 300, 5),
(3, 4, 'Intranet Actiane', 'Rachida Bouhaiss', 'toto', 'toto', 6, '2013-06-01', '2013-12-01', 'FDO', 'FDO', 240, 5);

-- --------------------------------------------------------

--
-- Structure de la table `responsable`
--

DROP TABLE IF EXISTS `responsable`;
CREATE TABLE IF NOT EXISTS `responsable` (
  `idParent` int(10) unsigned NOT NULL,
  `idEnfant` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idParent`,`idEnfant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `responsable`
--


-- --------------------------------------------------------

--
-- Structure de la table `typeconges`
--

DROP TABLE IF EXISTS `typeconges`;
CREATE TABLE IF NOT EXISTS `typeconges` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code_2` (`code`),
  KEY `libelle` (`libelle`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Contenu de la table `typeconges`
--

INSERT INTO `typeconges` (`id`, `code`, `libelle`) VALUES
(1, '#FF9900', 'Congés Payés'),
(2, '#FF0000', 'R.T.T.'),
(3, '#008888', 'Formation');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dateLastConnect` date DEFAULT NULL,
  `dateConnect` date DEFAULT NULL,
  `emailConfirm` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `passwordHasher` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`),
  KEY `emailConfirm` (`emailConfirm`),
  KEY `login_2` (`login`,`password`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `login`, `password`, `dateLastConnect`, `dateConnect`, `emailConfirm`, `passwordHasher`) VALUES
(1, 'skhemri', 'coucou', NULL, NULL, NULL, 'eX87PoMt'),
(2, 'fdouchet', 'coucou', NULL, NULL, NULL, 'eX87PoMu'),
(3, 'rbouaiss', 'coucou', NULL, NULL, NULL, 'eX87PoMv'),
(4, 'ngiraud', 'coucou', NULL, NULL, NULL, 'rT8Po5aY');

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `view_collaborationclient`
--
DROP VIEW IF EXISTS `view_collaborationclient`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_collaborationclient` AS select `a`.`id` AS `idCollaboration`,`a`.`idProjet` AS `idProjet`,`a`.`dateDebut` AS `debutCollab`,`a`.`dateFin` AS `finCollab`,`b`.`nomProjet` AS `nomProjet`,`c`.`id` AS `idClient`,`c`.`nom` AS `nomClient` from ((`collaboration` `a` join `projet` `b` on((`a`.`idProjet` = `b`.`idProjet`))) join `client` `c` on((`b`.`idClient` = `c`.`id`)));
