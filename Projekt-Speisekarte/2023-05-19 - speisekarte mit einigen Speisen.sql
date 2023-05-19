-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 19. Mai 2023 um 20:31
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

--
-- Daten für Tabelle `allergen`
--

INSERT INTO `allergen` (`allergen_id`, `klasse`, `name`, `beschreibung`) VALUES
(1, 'A', 'Glutenhaltiges Getreide', 'namentlich Weizen (wie Dinkel und Khorasan-Weizen), Roggen,\r\nGerste, Hafer oder Hybridstämme davon, sowie daraus hergestellte Erzeugnisse, ausgenommen\r\na) Glukosesirupe auf Weizenbasis einschließlich Dextrose ( 1 );\r\nb) Maltodextrine auf Weizenbasis ( 1 );\r\nc) Glukosesirupe auf Gerstenbasis;\r\nd) Getreide zur Herstellung von alkoholischen Destillaten einschließlich Ethylalkohol\r\nlandwirtschaftlichen Ursprungs'),
(2, 'B', 'Krebstiere', 'und daraus gewonnene Erzeugnisse.'),
(3, 'C', 'Eier', 'und daraus gewonnene Erzeugnisse.'),
(4, 'D', 'Fische', 'und daraus gewonnene Erzeugnisse, außer\r\na) Fischgelatine, die als Trägerstoff für Vitamin- oder Karotinoidzubereitungen verwendet wird;\r\nb) Fischgelatine oder Hausenblase, die als Klärhilfsmittel in Bier und Wein verwendet wird;'),
(5, 'E', 'Erdnüsse', 'und daraus gewonnene Erzeugnisse.'),
(6, 'F', 'Sojabohnen', 'und daraus gewonnene Erzeugnisse, außer\r\na) vollständig raffiniertes Sojabohnenöl und -fett ( 1 );\r\nb) natürliche gemischte Tocopherole (E306), natürliches D-alpha-Tocopherol, natürliches Dalpha-Tocopherolacetat, natürliches D-alpha-Tocopherolsukzinat aus Sojabohnenquellen;\r\nc) aus pflanzlichen Ölen gewonnene Phytosterine und Phytosterinester aus Sojabohnenquellen;\r\nd) aus Pflanzenölsterinen gewonnene Phytostanolester aus Sojabohnenquellen;'),
(7, 'G', 'Milch', 'und daraus gewonnene Erzeugnisse (einschließlich Laktose), außer\r\na) Molke zur Herstellung von alkoholischen Destillaten einschließlich Ethylalkohol\r\nlandwirtschaftlichen Ursprungs;\r\nb) Lactit;'),
(8, 'H', 'Schalenfrüchte', 'namentlich Mandeln (Amygdalus communis L.), Haselnüsse (Corylus\r\navellana), Walnüsse (Juglans regia), Kaschunüsse (Anacardium occidentale), Pecannüsse (Carya\r\nillinoiesis (Wangenh.) K. Koch), Paranüsse (Bertholletia excelsa), Pistazien (Pistacia vera),\r\nMacadamia- oder Queenslandnüsse (Macadamia ternifolia) sowie daraus gewonnene\r\nErzeugnisse, außer Nüssen zur Herstellung von alkoholischen Destillaten einschließlich\r\nEthylalkohol landwirtschaftlichen Ursprungs;'),
(9, 'L', 'Sellerie', 'und daraus gewonnene Erzeugnisse.'),
(10, 'M', 'Senf', 'und daraus gewonnene Erzeugnisse.'),
(11, 'N', 'Sesamsamen', 'und daraus gewonnene Erzeugnisse.'),
(12, 'O', 'Schwefeldioxid und Sulphite', 'in Konzentrationen von mehr als 10 mg/kg oder 10 mg/l\r\nals insgesamt vorhandenes SO 2 , die für verzehrfertige oder gemäß den Anweisungen des\r\nHerstellers in den ursprünglichen Zustand zurückgeführte Erzeugnisse zu berechnen sind.'),
(13, 'P', 'Lupinen', 'und daraus gewonnene Erzeugnisse.'),
(14, 'R', 'Weichtiere', 'und daraus gewonnene Erzeugnisse.');

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

--
-- Daten für Tabelle `benutzer`
--

INSERT INTO `benutzer` (`id`, `benutzer`, `vorname`, `nachname`, `passwort`, `email`) VALUES
(1, 'Helmut', 'H.', 'Berger', '$2y$10$iaiuLRkHm3sBP2Kb3coth.QKuFwgUAatEn2pEYginiOShVf5S/yyy', '');

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

--
-- Daten für Tabelle `bz_speise_allergene`
--

INSERT INTO `bz_speise_allergene` (`bz_sa`, `speise_id`, `getraenk_id`, `allergen_id`) VALUES
(1, 1, 0, 1),
(2, 1, 0, 3),
(3, 1, 0, 7),
(4, 2, 0, 7),
(5, 3, 0, 1),
(6, 3, 0, 7),
(7, 4, 0, 1),
(8, 4, 0, 7),
(9, 5, 0, 1),
(10, 5, 0, 7),
(11, 9, 0, 9),
(12, 7, 0, 9),
(13, 10, 0, 1),
(14, 0, 1, 12),
(15, 0, 2, 12),
(16, 12, 0, 1),
(17, 12, 0, 3),
(18, 12, 0, 7),
(19, 12, 0, 9),
(20, 12, 0, 10),
(21, 12, 0, 11),
(22, 13, 0, 1),
(23, 13, 0, 7),
(24, 13, 0, 10),
(25, 13, 0, 11),
(26, 16, 0, 1),
(27, 16, 0, 3),
(28, 16, 0, 4),
(29, 16, 0, 7),
(30, 16, 0, 8);

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

--
-- Daten für Tabelle `bz_speise_kategorie`
--

INSERT INTO `bz_speise_kategorie` (`bz_sk_id`, `aktiv`, `speise_id`, `getraenk_id`, `kategorie_id`, `einheit_id`, `menge`, `preis`) VALUES
(1, 1, 1, 0, 1, 1, 80, '16.90'),
(2, 1, 2, 0, 1, 4, 1, '10.90'),
(3, 1, 3, 0, 2, 5, 1, '4.90'),
(4, 1, 4, 0, 2, 4, 1, '6.90'),
(5, 1, 5, 0, 2, 5, 1, '3.90'),
(6, 1, 1, 0, 1, 1, 120, '19.90'),
(8, 1, 5, 0, 2, 9, 1, '5.60'),
(9, 1, 3, 0, 2, 8, 1, '5.90'),
(10, 1, 3, 0, 2, 9, 1, '6.20'),
(11, 1, 6, 0, 3, 4, 1, '4.90'),
(12, 1, 7, 0, 3, 4, 1, '11.90'),
(13, 1, 8, 0, 3, 4, 1, '4.50'),
(14, 1, 9, 0, 3, 4, 1, '13.90'),
(15, 1, 10, 0, 3, 4, 1, '14.50'),
(16, 1, 11, 0, 3, 4, 1, '12.50'),
(17, 1, 0, 1, 10, 11, 1, '4.90'),
(18, 1, 0, 2, 10, 11, 1, '3.90'),
(19, 1, 0, 2, 10, 10, 1, '23.90'),
(20, 1, 0, 1, 10, 10, 1, '28.90'),
(21, 1, 12, 0, 4, 4, 1, '17.90'),
(22, 1, 13, 0, 4, 4, 1, '19.90'),
(23, 1, 14, 0, 4, 4, 1, '29.90'),
(24, 1, 15, 0, 4, 4, 1, '34.90'),
(25, 1, 16, 0, 5, 4, 1, '23.90');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `einheit`
--

CREATE TABLE `einheit` (
  `einheit_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `kuerzel` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `einheit`
--

INSERT INTO `einheit` (`einheit_id`, `name`, `kuerzel`) VALUES
(1, 'Gramm', 'g'),
(2, 'Liter', 'l'),
(3, 'Stück', 'stk'),
(4, 'Portion', 'Port.'),
(5, 'Portion Frittaten', 'Port. Frittaten'),
(6, 'Milliliter', 'ml'),
(7, 'Centiliter', 'cl'),
(8, 'Stück Leberknödel', 'stk Leberknödel'),
(9, 'Stück Kaspressknödel', 'stk Kaspressknödel'),
(10, 'Flasche', 'Fl.'),
(11, 'Achterl', '1/8');

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

--
-- Daten für Tabelle `getraenk`
--

INSERT INTO `getraenk` (`getraenk_id`, `aktiv`, `deaktiviert_am`, `name`, `beschreibung`) VALUES
(1, 1, NULL, 'Grüner Veltliner', 'Weingut Berger'),
(2, 1, NULL, 'Gelber Muskateller - I Love Heideboden', 'Weingut Berger');

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

--
-- Daten für Tabelle `kategorie`
--

INSERT INTO `kategorie` (`kategorie_id`, `aktiv`, `typ`, `name`, `beschreibung`, `reihenfolge`, `farbe`) VALUES
(1, 1, 'Speise', 'Vorspeisen', 'Vorspeisen', 0, ''),
(2, 1, 'Speise', 'Aus dem Suppentopf', 'Aus dem Suppentopf', 1, ''),
(3, 1, 'Speise', 'Frische Salate', 'Frische Salate', 2, ''),
(4, 1, 'Speise', 'Vom Grill', 'Frisch und Saftig vom Grill', 4, ''),
(5, 1, 'Speise', 'Fischspezialitäten', 'Fischspezialitäten', 5, ''),
(6, 1, 'Speise', 'Klassiker', 'Klassiker', 3, ''),
(7, 1, 'Speise', 'Vegetarisch / Vegan', 'Vegetarisch / Vegan', 6, ''),
(8, 1, 'Speise', 'Zur Jaus`n', 'Zur Jaus`n', 7, ''),
(9, 1, 'Speise', 'Zum Nachtisch', 'Zuckerreduziert, aber trotzdem extem köstlich!', 8, ''),
(10, 1, 'Getränk', 'Weißweine', 'Weißweine', 104, ''),
(11, 1, 'Getränk', 'Rotweine', 'Rotweine', 103, ''),
(12, 1, 'Getränk', 'Bier vom Fass', 'Bier vom Fass', 101, ''),
(13, 1, 'Getränk', 'Flaschenbiere', 'Flaschenbiere', 102, ''),
(14, 1, 'Getränk', 'Alkoholfrei-Flaschen', 'Alkoholfrei-Flaschen', 106, ''),
(15, 1, 'Getränk', 'Alkoholfrei offen', 'Alkoholfrei offen', 105, ''),
(16, 1, 'Getränk', 'Schnäpse', 'Schnäpse', 108, ''),
(17, 1, 'Getränk', 'Heiße Getränke', 'Heiße Getränke', 107, '');

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
-- Daten für Tabelle `speise`
--

INSERT INTO `speise` (`speise_id`, `aktiv`, `deaktiviert_am`, `name`, `beschreibung`) VALUES
(1, 1, NULL, 'Beefsteak-Tartare vom Bio-Rind', 'mit Bio-Toast und Bio-Butter'),
(2, 1, NULL, 'Caprese vom Matthiashof Bio-Frischkäse', 'mit Ochsenherztomaten und Basilikumpesto'),
(3, 1, NULL, 'Kräftige Rindfleischsuppe vom Bio-Ochsen', 'mit Frittaten / Leberknödel /Kaspressknödel'),
(4, 1, NULL, 'Erdäpfel-Steinbierschaumsuppe', 'mit Buttercroútons'),
(5, 1, NULL, 'Hausgemachte Gemüsebouillon', 'mit Frittaten / Kaspressknödel'),
(6, 1, NULL, 'Gemischter Salat', 'Gemischter Salat'),
(7, 1, NULL, 'Bunter Blattsalat', 'mit Bio-Schafskäse und Zwiebelmarmelade'),
(8, 1, NULL, 'Blattsalat', 'Blattsalat'),
(9, 1, NULL, 'Bio-Schafskäse im Speckmantel', 'Blattsalat mit Karotte, Paprika, Tomate, Gurke & Zwiebelmarmelade'),
(10, 1, NULL, 'Steirischer Backhendlsalat', 'Blattsalat mit Karotte, Paprika, Tomate, Gurke und Kartoffelsalat, Kürbiskernöl und Preiselbeeren'),
(11, 1, NULL, 'Bauernsalat', 'Blattsalat mit Karotte, Paprika, Tomate, Gurke, Röstkartoffeln, gebratener Speck & Champignons'),
(12, 1, NULL, 'Cheesburger vom Bio-Rind (200g) im Bio-Brioche-Bun', 'mit Speck, Pommes-Frites, Bio-Gauda und hausgemachter Cocktail Sauce'),
(13, 1, NULL, 'Steaksandwich von Bio-Beirid (150g) im Bio-Roggen Sauerteigweckerl', 'mit Senfsauce dazu Pommes-Frittes und hausgemachter Cocktailsauce'),
(14, 1, NULL, 'Rumpsteak vom Bio-Beiried (200g)', 'serviert mit Rosmarinkartoffeln und Speckbohnen'),
(15, 1, NULL, 'Filetsteakvom Bio-Alpenrind', 'serviert mit Roasmarinkartoffeln und SPeckbohnen'),
(16, 1, NULL, 'Gebratenes Saiblingsfilet', 'mit Erbsenpüree und Buttergnocchi');

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
  MODIFY `allergen_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT für Tabelle `benutzer`
--
ALTER TABLE `benutzer`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `bz_speise_allergene`
--
ALTER TABLE `bz_speise_allergene`
  MODIFY `bz_sa` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT für Tabelle `bz_speise_kategorie`
--
ALTER TABLE `bz_speise_kategorie`
  MODIFY `bz_sk_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT für Tabelle `einheit`
--
ALTER TABLE `einheit`
  MODIFY `einheit_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT für Tabelle `getraenk`
--
ALTER TABLE `getraenk`
  MODIFY `getraenk_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `kategorie`
--
ALTER TABLE `kategorie`
  MODIFY `kategorie_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT für Tabelle `speise`
--
ALTER TABLE `speise`
  MODIFY `speise_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
