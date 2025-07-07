-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 07 juil. 2025 à 20:24
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `miniproject`
--

-- --------------------------------------------------------

--
-- Structure de la table `date_heures_fermees_`
--

CREATE TABLE `date_heures_fermees_` (
  `id` int(11) NOT NULL,
  `terrain_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `debut_fermeture` time NOT NULL,
  `fin_fermeture` time NOT NULL,
  `motif` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reservations_`
--

CREATE TABLE `reservations_` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `terrain_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `heure_debut` time NOT NULL,
  `heure_fin` time NOT NULL,
  `statut` enum('en attente','confirmée','annulée') NOT NULL DEFAULT 'en attente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reservations_`
--

INSERT INTO `reservations_` (`id`, `user_id`, `terrain_id`, `date`, `heure_debut`, `heure_fin`, `statut`) VALUES
(1, 4, 1, '2025-06-19', '22:00:00', '23:00:00', 'confirmée'),
(3, 4, 2, '2025-06-27', '14:00:00', '15:00:00', 'confirmée'),
(4, 8, 2, '2025-06-18', '13:00:00', '13:00:00', 'confirmée'),
(5, 8, 1, '2025-06-30', '20:00:00', '21:00:00', 'confirmée'),
(8, 4, 2, '2025-07-23', '07:00:00', '15:00:00', 'annulée'),
(13, 8, 1, '2025-07-09', '09:00:00', '17:00:00', 'en attente');

-- --------------------------------------------------------

--
-- Structure de la table `sports_`
--

CREATE TABLE `sports_` (
  `id` int(11) NOT NULL,
  `nom` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `sports_`
--

INSERT INTO `sports_` (`id`, `nom`) VALUES
(1, 'soccer'),
(3, 'basket');

-- --------------------------------------------------------

--
-- Structure de la table `terrains_`
--

CREATE TABLE `terrains_` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `sport_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `terrains_`
--

INSERT INTO `terrains_` (`id`, `nom`, `address`, `sport_id`) VALUES
(1, 'mohamed 6', 'sa3ada', 1),
(2, 'sa3ada', 'lagare', 3);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs_`
--

CREATE TABLE `utilisateurs_` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('client','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs_`
--

INSERT INTO `utilisateurs_` (`id`, `nom`, `email`, `password_hash`, `role`) VALUES
(4, 'rifi', 'rifi2@rifi.com', '$2y$10$6uJe21fxbMRy2ZF1wcImh.ie.cTKK6pFeH/UZPfMxMk/QlutEl9w6', 'client'),
(7, 'zohayr', 'zohayr@gmail.com', '$2y$10$nEvGphtPVqTpscz31qsGyOrfpOSk/HZ0J7JCazX4OqVZKXUJM6nEi', 'admin'),
(8, 'wail', 'wail@gmail.com', '$2y$10$khcxMjQs/0rOvMDJ5lAUbeivIlm1XmarKiryJnh0tqySBUvmYdsJa', 'client');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `date_heures_fermees_`
--
ALTER TABLE `date_heures_fermees_`
  ADD PRIMARY KEY (`id`),
  ADD KEY `terrain_id` (`terrain_id`);

--
-- Index pour la table `reservations_`
--
ALTER TABLE `reservations_`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `terrain_id` (`terrain_id`);

--
-- Index pour la table `sports_`
--
ALTER TABLE `sports_`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom` (`nom`) USING HASH;

--
-- Index pour la table `terrains_`
--
ALTER TABLE `terrains_`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sport_id` (`sport_id`);

--
-- Index pour la table `utilisateurs_`
--
ALTER TABLE `utilisateurs_`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `date_heures_fermees_`
--
ALTER TABLE `date_heures_fermees_`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reservations_`
--
ALTER TABLE `reservations_`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `sports_`
--
ALTER TABLE `sports_`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `terrains_`
--
ALTER TABLE `terrains_`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `utilisateurs_`
--
ALTER TABLE `utilisateurs_`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `date_heures_fermees_`
--
ALTER TABLE `date_heures_fermees_`
  ADD CONSTRAINT `date_heures_fermees__ibfk_1` FOREIGN KEY (`terrain_id`) REFERENCES `terrains_` (`id`);

--
-- Contraintes pour la table `reservations_`
--
ALTER TABLE `reservations_`
  ADD CONSTRAINT `reservations__ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `utilisateurs_` (`id`),
  ADD CONSTRAINT `reservations__ibfk_2` FOREIGN KEY (`terrain_id`) REFERENCES `terrains_` (`id`);

--
-- Contraintes pour la table `terrains_`
--
ALTER TABLE `terrains_`
  ADD CONSTRAINT `terrains__ibfk_1` FOREIGN KEY (`sport_id`) REFERENCES `sports_` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
