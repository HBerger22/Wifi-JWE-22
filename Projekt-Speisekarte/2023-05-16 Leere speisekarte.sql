-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 16. Mai 2023 um 18:39
-- Server-Version: 10.4.27-MariaDB
-- PHP-Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `speisekarte`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `allergen`
--

CREATE TABLE `allergen` (
  `allergen_id` int(10) UNSIGNED NOT NULL,
  `klasse` varchar(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `beschreibung` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `benutzer`
--

CREATE TABLE `benutzer` (
  `id` int(10) UNSIGNED NOT NULL,
  `benutzer` varchar(50) NOT NULL,
  `vorname` varchar(50) NOT NULL,
  `nachname` varchar(50) NOT NULL,
  `passwort` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bz_speise_allergene`
--

CREATE TABLE `bz_speise_allergene` (
  `bz_sa` int(10) UNSIGNED NOT NULL,
  `speise_id` int(10) UNSIGNED NOT NULL,
  `getraenk_id` int(10) UNSIGNED NOT NULL,
  `allergen_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bz_speise_kategorie`
--

CREATE TABLE `bz_speise_kategorie` (
  `bz_sk_id` int(10) UNSIGNED NOT NULL,
  `aktiv` tinyint(1) NOT NULL DEFAULT 0,
  `speise_id` int(10) UNSIGNED NOT NULL,
  `getraenk_id` int(11) UNSIGNED NOT NULL,
  `kategorie_id` int(10) UNSIGNED NOT NULL,
  `einheit_id` int(10) UNSIGNED DEFAULT NULL,
  `menge` float UNSIGNED DEFAULT NULL,
  `preis` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `einheit`
--

CREATE TABLE `einheit` (
  `einheit_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `kuerzel` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `getraenk`
--

CREATE TABLE `getraenk` (
  `getraenk_id` int(10) UNSIGNED NOT NULL,
  `aktiv` tinyint(1) NOT NULL DEFAULT 1,
  `deaktiviert_am` date DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `beschreibung` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `kategorie`
--

CREATE TABLE `kategorie` (
  `kategorie_id` int(11) UNSIGNED NOT NULL,
  `aktiv` tinyint(4) NOT NULL DEFAULT 1,
  `typ` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `beschreibung` varchar(255) NOT NULL,
  `reihenfolge` smallint(5) UNSIGNED NOT NULL,
  `farbe` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `speise`
--

CREATE TABLE `speise` (
  `speise_id` int(10) UNSIGNED NOT NULL,
  `aktiv` tinyint(1) NOT NULL DEFAULT 1,
  `deaktiviert_am` date DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `beschreibung` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `allergen`
--
ALTER TABLE `allergen`
  ADD PRIMARY KEY (`allergen_id`);

--
-- Indizes für die Tabelle `benutzer`
--
ALTER TABLE `benutzer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_u_benutzer` (`benutzer`),
  ADD UNIQUE KEY `idx_u_email` (`email`);

--
-- Indizes für die Tabelle `bz_speise_allergene`
--
ALTER TABLE `bz_speise_allergene`
  ADD PRIMARY KEY (`bz_sa`),
  ADD KEY `bz_speisen_allergene` (`speise_id`),
  ADD KEY `bz_allergene` (`allergen_id`);

--
-- Indizes für die Tabelle `bz_speise_kategorie`
--
ALTER TABLE `bz_speise_kategorie`
  ADD PRIMARY KEY (`bz_sk_id`),
  ADD KEY `bz_speisen` (`speise_id`),
  ADD KEY `bz_kategorie` (`kategorie_id`),
  ADD KEY `bz_einheit` (`einheit_id`);

--
-- Indizes für die Tabelle `einheit`
--
ALTER TABLE `einheit`
  ADD PRIMARY KEY (`einheit_id`);

--
-- Indizes für die Tabelle `getraenk`
--
ALTER TABLE `getraenk`
  ADD PRIMARY KEY (`getraenk_id`),
  ADD UNIQUE KEY `idx_sp_name` (`name`);

--
-- Indizes für die Tabelle `kategorie`
--
ALTER TABLE `kategorie`
  ADD PRIMARY KEY (`kategorie_id`);

--
-- Indizes für die Tabelle `speise`
--
ALTER TABLE `speise`
  ADD PRIMARY KEY (`speise_id`),
  ADD UNIQUE KEY `idx_sp_name` (`name`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `allergen`
--
ALTER TABLE `allergen`
  MODIFY `allergen_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `benutzer`
--
ALTER TABLE `benutzer`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `bz_speise_allergene`
--
ALTER TABLE `bz_speise_allergene`
  MODIFY `bz_sa` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `bz_speise_kategorie`
--
ALTER TABLE `bz_speise_kategorie`
  MODIFY `bz_sk_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `einheit`
--
ALTER TABLE `einheit`
  MODIFY `einheit_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `getraenk`
--
ALTER TABLE `getraenk`
  MODIFY `getraenk_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `kategorie`
--
ALTER TABLE `kategorie`
  MODIFY `kategorie_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `speise`
--
ALTER TABLE `speise`
  MODIFY `speise_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `bz_speise_allergene`
--
ALTER TABLE `bz_speise_allergene`
  ADD CONSTRAINT `bz_allergene` FOREIGN KEY (`allergen_id`) REFERENCES `allergen` (`allergen_id`);

--
-- Constraints der Tabelle `bz_speise_kategorie`
--
ALTER TABLE `bz_speise_kategorie`
  ADD CONSTRAINT `bz_kategorie` FOREIGN KEY (`kategorie_id`) REFERENCES `kategorie` (`kategorie_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
