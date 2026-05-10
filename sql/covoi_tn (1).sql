-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 05 mai 2026 à 13:28
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
-- Base de données : `covoi_tn`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `idAdmin` int(11) NOT NULL,
  `idUtilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`idAdmin`, `idUtilisateur`) VALUES
(1, 6);

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

CREATE TABLE `avis` (
  `idAvis` int(11) NOT NULL,
  `idReservation` int(11) NOT NULL,
  `note` int(11) NOT NULL,
  `commentaire` varchar(500) DEFAULT NULL,
  `dateAvis` datetime DEFAULT current_timestamp()
) ;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`idAvis`, `idReservation`, `note`, `commentaire`, `dateAvis`) VALUES
(2, 4, 4, 'bonne conducteur', '2026-05-03 02:02:47');

-- --------------------------------------------------------

--
-- Structure de la table `conducteur`
--

CREATE TABLE `conducteur` (
  `idConducteur` int(11) NOT NULL,
  `idUtilisateur` int(11) NOT NULL,
  `permisValide` tinyint(1) NOT NULL DEFAULT 0,
  `noteMoyenne` double DEFAULT 0
) ;

--
-- Déchargement des données de la table `conducteur`
--

INSERT INTO `conducteur` (`idConducteur`, `idUtilisateur`, `permisValide`, `noteMoyenne`) VALUES
(3, 7, 1, 4);

-- --------------------------------------------------------

--
-- Structure de la table `notification`
--

CREATE TABLE `notification` (
  `idNotification` int(11) NOT NULL,
  `idUtilisateur` int(11) NOT NULL,
  `contenu` varchar(200) NOT NULL,
  `typeNotif` varchar(50) DEFAULT NULL,
  `dateEnvoi` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `notification`
--

INSERT INTO `notification` (`idNotification`, `idUtilisateur`, `contenu`, `typeNotif`, `dateEnvoi`) VALUES
(3, 6, 'Bienvenue sur Covoit TN, dorai !', 'Bienvenue', '2026-05-01 00:00:32'),
(4, 7, 'Bienvenue sur Covoit TN, aymen !', 'Bienvenue', '2026-05-01 04:07:13'),
(5, 8, 'Bienvenue sur Covoit TN, nour !', 'Bienvenue', '2026-05-01 13:15:34'),
(6, 7, 'Nouvelle reservation pour votre trajet tunis - sousse', 'Reservation', '2026-05-01 14:24:12'),
(7, 8, 'Votre reservation a ete confirmee !', 'Confirmation', '2026-05-01 14:25:53'),
(8, 7, 'Nouvelle reservation pour votre trajet sfax - sousse', 'Reservation', '2026-05-03 01:59:35'),
(9, 8, 'Votre reservation a ete confirmee !', 'Confirmation', '2026-05-03 02:00:43');

-- --------------------------------------------------------

--
-- Structure de la table `passager`
--

CREATE TABLE `passager` (
  `idPassager` int(11) NOT NULL,
  `idUtilisateur` int(11) NOT NULL,
  `preferences` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `passager`
--

INSERT INTO `passager` (`idPassager`, `idUtilisateur`, `preferences`) VALUES
(4, 8, '');

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

CREATE TABLE `reservation` (
  `idReservation` int(11) NOT NULL,
  `idPassager` int(11) NOT NULL,
  `idTrajet` int(11) NOT NULL,
  `dateReservation` datetime DEFAULT current_timestamp(),
  `nbPlacesReservees` int(11) DEFAULT 1,
  `statut` varchar(20) DEFAULT 'En attente'
) ;

--
-- Déchargement des données de la table `reservation`
--

INSERT INTO `reservation` (`idReservation`, `idPassager`, `idTrajet`, `dateReservation`, `nbPlacesReservees`, `statut`) VALUES
(3, 4, 5, '2026-05-01 14:24:12', 2, 'Annulee'),
(4, 4, 6, '2026-05-03 01:59:35', 2, 'Terminee');

-- --------------------------------------------------------

--
-- Structure de la table `trajet`
--

CREATE TABLE `trajet` (
  `idTrajet` int(11) NOT NULL,
  `idConducteur` int(11) NOT NULL,
  `villeDepart` varchar(50) NOT NULL,
  `villeArrivee` varchar(50) NOT NULL,
  `dateDepart` datetime NOT NULL,
  `prixParPersonne` double NOT NULL,
  `statut` varchar(20) DEFAULT 'Actif'
) ;

--
-- Déchargement des données de la table `trajet`
--

INSERT INTO `trajet` (`idTrajet`, `idConducteur`, `villeDepart`, `villeArrivee`, `dateDepart`, `prixParPersonne`, `statut`) VALUES
(5, 3, 'tunis', 'sousse', '2026-05-01 12:00:00', 12, 'Actif'),
(6, 3, 'sfax', 'sousse', '2026-05-04 15:45:00', 10, 'Actif');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `idUtilisateur` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `motDepasse` varchar(100) NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`idUtilisateur`, `nom`, `prenom`, `email`, `telephone`, `motDepasse`, `role`) VALUES
(6, 'abir', 'dorai', 'abir.dorai@esen.tn', '21340838', '$2y$10$aWq.yFIOHlr9KUNBy2lJAupuab.B1hEPsWYv4Gx2dojTG33yXYu.O', 'admin'),
(7, 'aymen', 'aymen', 'aymen@gmail.com', '21445255', '$2y$10$uCK97b4WN8xi1UBEOH0SMOhjaHTUFdvBvQC1KBtt7yo7M7yQVKNBu', 'Conducteur'),
(8, 'nour', 'nour', 'nour@gmail.com', '21345666', '$2y$10$MydBMWKhweOvqkDRXaYZse3iElZYes85MSmosA64LoDNQysSPAQzW', 'Passager');

-- --------------------------------------------------------

--
-- Structure de la table `voiture`
--

CREATE TABLE `voiture` (
  `idVoiture` int(11) NOT NULL,
  `idConducteur` int(11) NOT NULL,
  `marque` varchar(50) NOT NULL,
  `modele` varchar(50) DEFAULT NULL,
  `plaque` varchar(20) NOT NULL,
  `placesDisponibles` int(11) DEFAULT 4
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `voiture`
--

INSERT INTO `voiture` (`idVoiture`, `idConducteur`, `marque`, `modele`, `plaque`, `placesDisponibles`) VALUES
(3, 3, 'peugot', '208', '123 tunis 77', 4);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`idAdmin`),
  ADD UNIQUE KEY `idUtilisateur` (`idUtilisateur`);

--
-- Index pour la table `avis`
--
ALTER TABLE `avis`
  ADD PRIMARY KEY (`idAvis`),
  ADD UNIQUE KEY `idReservation` (`idReservation`);

--
-- Index pour la table `conducteur`
--
ALTER TABLE `conducteur`
  ADD PRIMARY KEY (`idConducteur`),
  ADD UNIQUE KEY `idUtilisateur` (`idUtilisateur`);

--
-- Index pour la table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`idNotification`),
  ADD KEY `idUtilisateur` (`idUtilisateur`);

--
-- Index pour la table `passager`
--
ALTER TABLE `passager`
  ADD PRIMARY KEY (`idPassager`),
  ADD UNIQUE KEY `idUtilisateur` (`idUtilisateur`);

--
-- Index pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`idReservation`),
  ADD KEY `idPassager` (`idPassager`),
  ADD KEY `idTrajet` (`idTrajet`);

--
-- Index pour la table `trajet`
--
ALTER TABLE `trajet`
  ADD PRIMARY KEY (`idTrajet`),
  ADD KEY `idConducteur` (`idConducteur`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`idUtilisateur`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `voiture`
--
ALTER TABLE `voiture`
  ADD PRIMARY KEY (`idVoiture`),
  ADD UNIQUE KEY `plaque` (`plaque`),
  ADD KEY `idConducteur` (`idConducteur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `idAdmin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `avis`
--
ALTER TABLE `avis`
  MODIFY `idAvis` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `conducteur`
--
ALTER TABLE `conducteur`
  MODIFY `idConducteur` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `notification`
--
ALTER TABLE `notification`
  MODIFY `idNotification` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `passager`
--
ALTER TABLE `passager`
  MODIFY `idPassager` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `idReservation` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `trajet`
--
ALTER TABLE `trajet`
  MODIFY `idTrajet` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `idUtilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `voiture`
--
ALTER TABLE `voiture`
  MODIFY `idVoiture` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateur` (`idUtilisateur`) ON DELETE CASCADE;

--
-- Contraintes pour la table `avis`
--
ALTER TABLE `avis`
  ADD CONSTRAINT `avis_ibfk_1` FOREIGN KEY (`idReservation`) REFERENCES `reservation` (`idReservation`);

--
-- Contraintes pour la table `conducteur`
--
ALTER TABLE `conducteur`
  ADD CONSTRAINT `conducteur_ibfk_1` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateur` (`idUtilisateur`) ON DELETE CASCADE;

--
-- Contraintes pour la table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateur` (`idUtilisateur`);

--
-- Contraintes pour la table `passager`
--
ALTER TABLE `passager`
  ADD CONSTRAINT `passager_ibfk_1` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateur` (`idUtilisateur`) ON DELETE CASCADE;

--
-- Contraintes pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`idPassager`) REFERENCES `passager` (`idPassager`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`idTrajet`) REFERENCES `trajet` (`idTrajet`);

--
-- Contraintes pour la table `trajet`
--
ALTER TABLE `trajet`
  ADD CONSTRAINT `trajet_ibfk_1` FOREIGN KEY (`idConducteur`) REFERENCES `conducteur` (`idConducteur`);

--
-- Contraintes pour la table `voiture`
--
ALTER TABLE `voiture`
  ADD CONSTRAINT `voiture_ibfk_1` FOREIGN KEY (`idConducteur`) REFERENCES `conducteur` (`idConducteur`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
