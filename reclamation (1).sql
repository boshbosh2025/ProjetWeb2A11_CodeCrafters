-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 04 déc. 2024 à 00:26
-- Version du serveur : 11.5.2-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `reclamation`
--

-- --------------------------------------------------------

--
-- Structure de la table `reclamations`
--

CREATE TABLE `reclamations` (
  `id` int(11) NOT NULL,
  `id_utilisateur` varchar(255) DEFAULT NULL,
  `type_reclamation` varchar(50) DEFAULT NULL,
  `cours_nom` varchar(255) DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `date_creation` timestamp NULL DEFAULT current_timestamp(),
  `statut` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `reclamations`
--

INSERT INTO `reclamations` (`id`, `id_utilisateur`, `type_reclamation`, `cours_nom`, `transaction_id`, `description`, `date_creation`, `statut`) VALUES
(2, '1', 'cours', 'kljklj', '', 'hjkjk', '2024-12-03 22:06:56', 'rejeter'),
(4, '1', 'paiement', '', '2', 'kll', '2024-12-03 22:07:52', 'rejeter'),
(16, '1', 'technique', '', '', 'kllkl', '2024-12-03 23:07:56', 'accepter');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `reclamations`
--
ALTER TABLE `reclamations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `reclamations`
--
ALTER TABLE `reclamations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
