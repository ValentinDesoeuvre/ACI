-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Dim 10 Mai 2020 à 10:14
-- Version du serveur :  5.7.11
-- Version de PHP :  7.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `mydb`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `idCategories` int(11) NOT NULL,
  `nom` varchar(45) NOT NULL,
  `themes_idThemes` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `categories`
--

INSERT INTO `categories` (`idCategories`, `nom`, `themes_idThemes`) VALUES
(1, 'Recherche et veille d\'information', 1),
(2, 'Gérer des données', 1),
(3, 'Traiter des données', 1),
(4, 'Interagir', 2),
(5, 'Partager et publier', 2),
(6, 'Collaborer', 2),
(7, 'S\'insérer dans le monde numérique', 2),
(8, 'Développer des documents textuels', 3),
(9, 'Développer des documents multimédia', 3),
(10, 'Adapter les documents à leur finalité', 3),
(11, 'Programmer', 3),
(12, 'Sécuriser l\'environnement numérique', 4),
(13, 'Protéger données personnelles et vie privée', 4),
(14, 'Protéger santé, bien-être et environnement', 4),
(15, 'Résoudre des problèmes techniques', 5),
(16, 'Construire un environnement numérique', 5);

-- --------------------------------------------------------

--
-- Structure de la table `questions`
--

CREATE TABLE `questions` (
  `idQuestions` int(11) NOT NULL,
  `intitule` varchar(120) NOT NULL,
  `detail` tinytext NOT NULL,
  `typeQuestion` int(11) NOT NULL,
  `urlQuestion` tinytext,
  `lienQuestion` tinytext,
  `typeReponse` int(11) NOT NULL,
  `niveau` int(11) NOT NULL,
  `bonneReponse` tinytext,
  `reponsesPossibles` tinytext,
  `categories_idCategories` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `reponses`
--

CREATE TABLE `reponses` (
  `idreponses` int(11) NOT NULL,
  `contenu` tinytext NOT NULL,
  `ifTrue` tinyint(1) NOT NULL DEFAULT '0',
  `questions_idQuestions` int(11) NOT NULL,
  `utilisateurs_idUtilisateurs` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `themes`
--

CREATE TABLE `themes` (
  `idThemes` int(11) NOT NULL,
  `nom` varchar(45) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `themes`
--

INSERT INTO `themes` (`idThemes`, `nom`) VALUES
(1, 'Informations et données'),
(2, 'Communication et collaboration'),
(3, 'Création de contenu'),
(4, 'Protection et sécurité'),
(5, 'Environnement numérique');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `idUtilisateurs` int(11) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `ifadmin` tinyint(1) NOT NULL DEFAULT '0',
  `actif` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`idUtilisateurs`, `mdp`, `ifadmin`, `actif`) VALUES
(1, '$2y$10$QNEBZaYGgZbHQfFlQNzu5.e/pxa/QF5W9Np1coNtLB1jQVCR8AId2', 1, 1),
(2, '$2y$10$QNEBZaYGgZbHQfFlQNzu5.e/pxa/QF5W9Np1coNtLB1jQVCR8AId2', 0, 1);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`idCategories`,`themes_idThemes`),
  ADD UNIQUE KEY `nom_UNIQUE` (`nom`),
  ADD KEY `fk_categories_themes1_idx` (`themes_idThemes`);

--
-- Index pour la table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`idQuestions`,`categories_idCategories`),
  ADD KEY `fk_questions_categories1_idx` (`categories_idCategories`);

--
-- Index pour la table `reponses`
--
ALTER TABLE `reponses`
  ADD PRIMARY KEY (`idreponses`,`questions_idQuestions`,`utilisateurs_idUtilisateurs`),
  ADD KEY `fk_reponses_questions1_idx` (`questions_idQuestions`),
  ADD KEY `fk_reponses_utilisateurs1_idx` (`utilisateurs_idUtilisateurs`);

--
-- Index pour la table `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`idThemes`),
  ADD UNIQUE KEY `nom_UNIQUE` (`nom`),
  ADD UNIQUE KEY `idthemes_UNIQUE` (`idThemes`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`idUtilisateurs`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `idCategories` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT pour la table `questions`
--
ALTER TABLE `questions`
  MODIFY `idQuestions` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `reponses`
--
ALTER TABLE `reponses`
  MODIFY `idreponses` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `themes`
--
ALTER TABLE `themes`
  MODIFY `idThemes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `idUtilisateurs` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
