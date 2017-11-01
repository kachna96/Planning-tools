-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Pon 05. led 2015, 22:03
-- Verze serveru: 5.6.16
-- Verze PHP: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `mydb`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `spolecnost`
--

CREATE TABLE IF NOT EXISTS `spolecnost` (
  `idspolecnost` int(11) NOT NULL AUTO_INCREMENT,
  `jmeno_spolecnosti` varchar(150) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`idspolecnost`),
  UNIQUE KEY `jmeno_spolecnosti` (`jmeno_spolecnosti`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=46 ;

--
-- Vypisuji data pro tabulku `spolecnost`
--

INSERT INTO `spolecnost` (`idspolecnost`, `jmeno_spolecnosti`) VALUES
(45, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa společnost'),
(43, 'grav společnost'),
(42, 'Moje společnost'),
(44, 'Moje společnost společnost');

-- --------------------------------------------------------

--
-- Struktura tabulky `ukoly`
--

CREATE TABLE IF NOT EXISTS `ukoly` (
  `idukoly` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(120) COLLATE utf8_czech_ci DEFAULT NULL,
  `ukol` text COLLATE utf8_czech_ci NOT NULL,
  `narocnost` time NOT NULL,
  `zacatek` datetime NOT NULL,
  `konec` datetime NOT NULL,
  `saturday` tinyint(1) NOT NULL DEFAULT '0',
  `sunday` tinyint(1) NOT NULL DEFAULT '0',
  `vlozil` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `spolecnost_idspolecnost` int(11) NOT NULL,
  PRIMARY KEY (`idukoly`),
  KEY `nazev` (`nazev`) USING BTREE,
  KEY `fk_ukoly_spolecnost1_idx` (`spolecnost_idspolecnost`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=31 ;

--
-- Vypisuji data pro tabulku `ukoly`
--

INSERT INTO `ukoly` (`idukoly`, `nazev`, `ukol`, `narocnost`, `zacatek`, `konec`, `saturday`, `sunday`, `vlozil`, `spolecnost_idspolecnost`) VALUES
(3, 'asdf', 'asdf', '07:00:00', '2014-12-16 19:05:00', '2014-12-17 14:05:00', 1, 1, 'kachna96@gmail.com', 42),
(4, 'uklo', 'kol', '03:15:00', '2014-12-17 17:15:00', '2014-12-17 20:30:00', 1, 1, 'kachna96@gmail.com', 42),
(7, 'aaass', 'sss', '01:00:00', '2014-12-17 18:15:00', '2014-12-17 19:15:00', 1, 1, 'kachna96@gmail.com', 42),
(8, 'asdfdsdsf', 'dsdsdss', '02:00:00', '2014-12-17 18:15:00', '2014-12-17 20:00:00', 1, 1, 'kachna96@gmail.com', 42),
(9, 'asdfdsdsf', 'dsdsdss', '02:00:00', '2014-12-17 18:20:00', '2014-12-17 20:00:00', 1, 1, 'kachna96@gmail.com', 42),
(11, 'Testovací', 'úkol', '01:00:00', '2014-12-17 18:35:00', '2014-12-17 19:35:00', 1, 1, 'kachna96@gmail.com', 42),
(12, 'ukol', 'asdf', '20:00:00', '2014-12-18 15:20:00', '2014-12-20 11:20:00', 1, 1, 'kachna96@gmail.com', 42),
(13, 'asdffdd', 'fsddsffsdsfasdfssdfsdsdsd', '81:15:00', '2014-12-20 20:45:00', '2015-01-06 18:00:00', 0, 0, 'kachna96@gmail.com', 42),
(14, 'asdsdsdfsd', 'sddssddsds', '265:00:00', '2014-12-20 21:00:00', '2015-01-15 22:00:00', 1, 1, 'kachna96@gmail.com', 42),
(15, 'asdfsdf', 'fsdffsdsf', '96:00:00', '2014-12-20 21:00:00', '2014-12-31 21:00:00', 1, 1, 'kachna96@gmail.com', 42),
(16, 'asdfasdffadasdf', 'dasfdasfdfsasdffsdasd', '97:00:00', '2014-12-20 21:00:00', '2014-12-31 22:00:00', 1, 1, 'kachna96@gmail.com', 42),
(17, 'afdfasdadfsas', 'dfasdfasdfasdfdasfdasf', '97:00:00', '2014-12-20 21:00:00', '2014-12-31 22:00:00', 1, 1, 'kachna96@gmail.com', 42),
(18, 'fasdasdfasdf', 'adfsdsfsdfdsfsdds', '97:00:00', '2014-12-20 21:00:00', '2015-01-02 22:00:00', 0, 1, 'kachna96@gmail.com', 42),
(19, 'dsfdsfdfssdf', 'dsdsfsdsddsds', '96:00:00', '2014-12-20 21:00:00', '2014-12-31 21:00:00', 1, 1, 'kachna96@gmail.com', 42),
(20, 'sddsdsdsds', 'sdsdsddsdsds', '97:00:00', '2014-12-20 21:00:00', '2014-12-31 22:00:00', 1, 1, 'kachna96@gmail.com', 42),
(21, 'sdsddsdss', 'ddsdsdsdsds', '97:00:00', '2014-12-20 21:00:00', '2014-12-31 22:00:00', 1, 1, 'kachna96@gmail.com', 42),
(22, 'dsfdfassd', 'dssd', '72:00:00', '2014-12-20 21:00:00', '2014-12-31 21:00:00', 0, 1, 'kachna96@gmail.com', 42),
(23, 'sdsdsddsds', 'dsdsdsdsds', '97:00:00', '2014-12-20 21:00:00', '2014-12-31 22:00:00', 1, 1, 'kachna96@gmail.com', 42),
(24, 'dsdsdsds', 'dsdssdsddsds', '229:25:00', '2014-12-20 21:00:00', '2015-01-23 10:25:00', 0, 0, 'kachna96@gmail.com', 42),
(25, 'dssddssd', 'dsdsdsds', '48:00:00', '2014-12-20 21:00:00', '2014-12-31 21:00:00', 0, 0, 'kachna96@gmail.com', 42),
(26, 'sdsddsdsds', 'dsdsdsds', '97:00:00', '2014-12-20 21:00:00', '2014-12-31 22:00:00', 1, 1, 'kachna96@gmail.com', 42),
(27, 'dadsssdds', 'sdasddasas', '97:00:00', '2014-12-20 21:00:00', '2014-12-31 22:00:00', 1, 1, 'kachna96@gmail.com', 42),
(28, 'sdsddsdsdsds', 'dssddssd', '97:00:00', '2014-12-20 21:00:00', '2014-12-31 22:00:00', 1, 1, 'kachna96@gmail.com', 42),
(29, 'ukol', 'ass', '192:10:00', '2015-01-13 17:30:00', '2015-01-29 17:40:00', 1, 1, 'kachna96@gmail.com', 42),
(30, 'kjh', 'kk', '01:00:00', '2015-01-07 19:10:00', '2015-01-07 20:10:00', 1, 1, 'kachna96@gmail.com', 42);

-- --------------------------------------------------------

--
-- Struktura tabulky `uzivatele`
--

CREATE TABLE IF NOT EXISTS `uzivatele` (
  `iduzivatele` int(11) NOT NULL AUTO_INCREMENT,
  `jmeno` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `heslo` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `role` varchar(25) COLLATE utf8_czech_ci NOT NULL DEFAULT 'user',
  `work_start` varchar(5) COLLATE utf8_czech_ci NOT NULL DEFAULT '08:00',
  `work_end` varchar(5) COLLATE utf8_czech_ci NOT NULL DEFAULT '16:00',
  `saturday_work` tinyint(1) NOT NULL DEFAULT '0',
  `sunday_work` tinyint(1) NOT NULL DEFAULT '0',
  `spolecnost_idspolecnost` int(11) DEFAULT NULL,
  PRIMARY KEY (`iduzivatele`),
  UNIQUE KEY `jmeno_2` (`jmeno`),
  KEY `jmeno` (`jmeno`) USING BTREE,
  KEY `fk_uzivatele_spolecnost1_idx` (`spolecnost_idspolecnost`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=73 ;

--
-- Vypisuji data pro tabulku `uzivatele`
--

INSERT INTO `uzivatele` (`iduzivatele`, `jmeno`, `heslo`, `role`, `work_start`, `work_end`, `saturday_work`, `sunday_work`, `spolecnost_idspolecnost`) VALUES
(62, 'dostavník', '$2y$10$x4xmMLv45cfmHN0yfyx1uujOUoibkUH/1onTVYJKeJkijTJCbuYbC', 'admin', '07:00', '20:00', 0, 0, 42),
(63, 'kachna96', '$2y$10$dVmkoHczYxq8MtCtiSOZ.usXp5in6KL78z20wgumKQ6UiipG0XY5S', 'admin', '07:00', '20:00', 0, 0, 42),
(64, 'kachna96@gmail.com', '$2y$10$taNrxYVbYPesgBtv5TpGUuTEoBfPxS/c3HK3QU6eBeKTQazzNMbf.', 'admin', '07:00', '22:00', 1, 1, 42),
(65, 'grav', '$2y$10$8Ti0fCL6DMuzRmgIX4YPU.BPn/XWjgtUPI.pcn4MVOhyhHwMwriwW', 'admin', '08:00', '16:00', 0, 0, 43),
(66, 'Moje společnost', '$2y$10$G6e/R9kJAvfFZ3xiEkgwc.yAxhznwdz0wNNIsjGpeVKFyx9Es34mG', 'admin', '08:00', '16:00', 0, 0, 44),
(67, 'uzivatel', '$2y$10$pAuAMbpYdCxkiEu7XVNcKenWfNIRsONfhBpXsOgiz.koIK4K5uuri', 'admin', '07:00', '20:00', 0, 0, 42),
(69, 'uzivatel3', '$2y$10$9hIr8F2BpxXNw.U6VGKz0u7vvneyGfyX7S/zefCIIRahP3cmH341O', 'user', '07:00', '20:00', 0, 0, 42),
(70, 'uzivatel4', '$2y$10$i7TEU1OhfqeNa8c4sQz3r.qWu8KmhCjKoSZdAhMoMBzmUNXttjtEm', 'user', '07:00', '20:00', 0, 0, 42),
(71, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '$2y$10$8R3k3pxfjuwS6z0XJUZ9QOCXIcqeph3BK20aG0mcQioYfP55i4H8e', 'user', '08:00', '16:00', 0, 0, 42),
(72, 'aaaaaaa', '$2y$10$wjrpR06qO8O/e5.b5001ZeTzsplp5bakBieVOW4moE7CsP6CnikKO', 'admin', '08:00', '16:00', 0, 0, 45);

-- --------------------------------------------------------

--
-- Struktura tabulky `volno`
--

CREATE TABLE IF NOT EXISTS `volno` (
  `idvolno` int(11) NOT NULL AUTO_INCREMENT,
  `datum` date NOT NULL,
  `do` date DEFAULT NULL,
  `ucel` enum('Státní svátek','Dovolená','Závodní dovolená') COLLATE utf8_czech_ci NOT NULL DEFAULT 'Dovolená',
  `popis` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  `com_id` int(11) DEFAULT NULL,
  `prace` tinyint(1) NOT NULL DEFAULT '0',
  `uzivatele_iduzivatele` int(11) NOT NULL,
  PRIMARY KEY (`idvolno`),
  KEY `fk_volno_uzivatele1_idx` (`uzivatele_iduzivatele`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=277 ;

--
-- Vypisuji data pro tabulku `volno`
--

INSERT INTO `volno` (`idvolno`, `datum`, `do`, `ucel`, `popis`, `com_id`, `prace`, `uzivatele_iduzivatele`) VALUES
(64, '0000-01-01', NULL, 'Státní svátek', 'Den obnovy samostatného českého státu ( 1.1. )', NULL, 0, 62),
(65, '0000-05-01', NULL, 'Státní svátek', 'Svátek práce ( 1.5. )', NULL, 0, 62),
(66, '0000-04-21', NULL, 'Státní svátek', 'Velikonoční pondělí ( 21.4. )', NULL, 0, 62),
(67, '0000-05-08', NULL, 'Státní svátek', 'Den vítězství ( 8.5. )', NULL, 0, 62),
(68, '0000-07-05', NULL, 'Státní svátek', 'Den slovanských věrozvěstů Cyrila a Metoděje ( 5.7. )', NULL, 0, 62),
(69, '0000-07-06', NULL, 'Státní svátek', 'Den upálení mistra Jana Husa ( 6.7. )', NULL, 0, 62),
(70, '0000-09-28', NULL, 'Státní svátek', 'Den české státnosti ( 28.9. )', NULL, 0, 62),
(71, '0000-10-28', NULL, 'Státní svátek', 'Den vzniku samostatného československého státu ( 28.10. )', NULL, 0, 62),
(72, '0000-11-17', NULL, 'Státní svátek', 'Den boje za svobodu a demokracii ( 17.11. )', NULL, 0, 62),
(73, '0000-12-24', NULL, 'Státní svátek', 'Štědrý den ( 24.12. )', NULL, 0, 62),
(74, '0000-12-25', NULL, 'Státní svátek', '1. svátek vánoční ( 25.12. )', NULL, 0, 62),
(75, '0000-12-26', NULL, 'Státní svátek', '2. svátek vánoční ( 26.12. )', NULL, 0, 62),
(77, '0000-01-01', NULL, 'Státní svátek', 'Den obnovy samostatného českého státu ( 1.1. )', NULL, 0, 63),
(78, '0000-05-01', NULL, 'Státní svátek', 'Svátek práce ( 1.5. )', NULL, 0, 63),
(79, '0000-04-21', NULL, 'Státní svátek', 'Velikonoční pondělí ( 21.4. )', NULL, 0, 63),
(80, '0000-05-08', NULL, 'Státní svátek', 'Den vítězství ( 8.5. )', NULL, 0, 63),
(81, '0000-07-05', NULL, 'Státní svátek', 'Den slovanských věrozvěstů Cyrila a Metoděje ( 5.7. )', NULL, 0, 63),
(82, '0000-07-06', NULL, 'Státní svátek', 'Den upálení mistra Jana Husa ( 6.7. )', NULL, 0, 63),
(83, '0000-09-28', NULL, 'Státní svátek', 'Den české státnosti ( 28.9. )', NULL, 0, 63),
(84, '0000-10-28', NULL, 'Státní svátek', 'Den vzniku samostatného československého státu ( 28.10. )', NULL, 0, 63),
(85, '0000-11-17', NULL, 'Státní svátek', 'Den boje za svobodu a demokracii ( 17.11. )', NULL, 0, 63),
(86, '0000-12-24', NULL, 'Státní svátek', 'Štědrý den ( 24.12. )', NULL, 0, 63),
(87, '0000-12-25', NULL, 'Státní svátek', '1. svátek vánoční ( 25.12. )', NULL, 0, 63),
(88, '0000-12-26', NULL, 'Státní svátek', '2. svátek vánoční ( 26.12. )', NULL, 0, 63),
(89, '0000-01-01', NULL, 'Státní svátek', 'Den obnovy samostatného českého státu ( 1.1. )', NULL, 0, 64),
(90, '0000-05-01', NULL, 'Státní svátek', 'Svátek práce ( 1.5. )', NULL, 0, 64),
(91, '0000-04-21', NULL, 'Státní svátek', 'Velikonoční pondělí ( 21.4. )', NULL, 0, 64),
(92, '0000-05-08', NULL, 'Státní svátek', 'Den vítězství ( 8.5. )', NULL, 0, 64),
(93, '0000-07-05', NULL, 'Státní svátek', 'Den slovanských věrozvěstů Cyrila a Metoděje ( 5.7. )', NULL, 0, 64),
(94, '0000-07-06', NULL, 'Státní svátek', 'Den upálení mistra Jana Husa ( 6.7. )', NULL, 0, 64),
(95, '0000-09-28', NULL, 'Státní svátek', 'Den české státnosti ( 28.9. )', NULL, 0, 64),
(96, '0000-10-28', NULL, 'Státní svátek', 'Den vzniku samostatného československého státu ( 28.10. )', NULL, 0, 64),
(97, '0000-11-17', NULL, 'Státní svátek', 'Den boje za svobodu a demokracii ( 17.11. )', NULL, 0, 64),
(98, '0000-12-24', NULL, 'Státní svátek', 'Štědrý den ( 24.12. )', NULL, 0, 64),
(99, '0000-12-25', NULL, 'Státní svátek', '1. svátek vánoční ( 25.12. )', NULL, 0, 64),
(100, '0000-12-26', NULL, 'Státní svátek', '2. svátek vánoční ( 26.12. )', NULL, 0, 64),
(101, '2014-12-05', NULL, 'Dovolená', '', NULL, 0, 64),
(102, '2014-12-05', NULL, 'Dovolená', 'asdasdasdasdasdasdasdasd', NULL, 0, 64),
(103, '0000-01-01', NULL, 'Státní svátek', 'Den obnovy samostatného českého státu ( 1.1. )', NULL, 0, 65),
(104, '0000-05-01', NULL, 'Státní svátek', 'Svátek práce ( 1.5. )', NULL, 0, 65),
(105, '0000-04-21', NULL, 'Státní svátek', 'Velikonoční pondělí ( 21.4. )', NULL, 0, 65),
(106, '0000-05-08', NULL, 'Státní svátek', 'Den vítězství ( 8.5. )', NULL, 0, 65),
(107, '0000-07-05', NULL, 'Státní svátek', 'Den slovanských věrozvěstů Cyrila a Metoděje ( 5.7. )', NULL, 0, 65),
(108, '0000-07-06', NULL, 'Státní svátek', 'Den upálení mistra Jana Husa ( 6.7. )', NULL, 0, 65),
(109, '0000-09-28', NULL, 'Státní svátek', 'Den české státnosti ( 28.9. )', NULL, 0, 65),
(110, '0000-10-28', NULL, 'Státní svátek', 'Den vzniku samostatného československého státu ( 28.10. )', NULL, 0, 65),
(111, '0000-11-17', NULL, 'Státní svátek', 'Den boje za svobodu a demokracii ( 17.11. )', NULL, 0, 65),
(112, '0000-12-24', NULL, 'Státní svátek', 'Štědrý den ( 24.12. )', NULL, 0, 65),
(113, '0000-12-25', NULL, 'Státní svátek', '1. svátek vánoční ( 25.12. )', NULL, 0, 65),
(114, '0000-12-26', NULL, 'Státní svátek', '2. svátek vánoční ( 26.12. )', NULL, 0, 65),
(115, '2014-12-06', '2014-12-07', 'Dovolená', 'dsfsdffsddsfdsffsddssdf', NULL, 0, 64),
(116, '2014-12-06', NULL, 'Dovolená', '', NULL, 0, 64),
(117, '2014-12-06', NULL, 'Dovolená', '', NULL, 0, 64),
(118, '2014-12-07', NULL, 'Dovolená', '', NULL, 0, 64),
(119, '2014-12-31', NULL, 'Dovolená', '', NULL, 0, 62),
(120, '2014-12-31', NULL, 'Dovolená', '', NULL, 0, 63),
(149, '2014-12-11', NULL, 'Dovolená', '', NULL, 0, 64),
(150, '2014-12-11', '2014-12-12', 'Dovolená', '', NULL, 0, 64),
(151, '2014-12-12', NULL, 'Dovolená', 'asdf', NULL, 0, 64),
(152, '2014-12-12', NULL, 'Dovolená', '', NULL, 0, 64),
(153, '2014-12-13', NULL, 'Dovolená', '', NULL, 0, 64),
(154, '2014-12-13', '2014-12-18', 'Dovolená', '', NULL, 0, 64),
(156, '2014-12-13', NULL, 'Dovolená', '', NULL, 0, 64),
(157, '2014-12-13', NULL, 'Dovolená', '', NULL, 0, 64),
(158, '2014-12-13', NULL, 'Dovolená', '', NULL, 0, 64),
(159, '2014-12-13', NULL, 'Dovolená', '', NULL, 0, 64),
(163, '2014-12-13', NULL, 'Závodní dovolená', '', 42, 0, 64),
(165, '2014-12-13', NULL, 'Dovolená', '', NULL, 0, 64),
(166, '2014-12-13', NULL, 'Dovolená', '', NULL, 0, 64),
(167, '2014-12-13', NULL, 'Dovolená', '', NULL, 0, 64),
(168, '0000-01-01', NULL, 'Státní svátek', 'Den obnovy samostatného českého státu ( 1.1. )', NULL, 0, 66),
(169, '0000-05-01', NULL, 'Státní svátek', 'Svátek práce ( 1.5. )', NULL, 0, 66),
(170, '0000-04-21', NULL, 'Státní svátek', 'Velikonoční pondělí ( 21.4. )', NULL, 0, 66),
(171, '0000-05-08', NULL, 'Státní svátek', 'Den vítězství ( 8.5. )', NULL, 0, 66),
(172, '0000-07-05', NULL, 'Státní svátek', 'Den slovanských věrozvěstů Cyrila a Metoděje ( 5.7. )', NULL, 0, 66),
(173, '0000-07-06', NULL, 'Státní svátek', 'Den upálení mistra Jana Husa ( 6.7. )', NULL, 0, 66),
(174, '0000-09-28', NULL, 'Státní svátek', 'Den české státnosti ( 28.9. )', NULL, 0, 66),
(175, '0000-10-28', NULL, 'Státní svátek', 'Den vzniku samostatného československého státu ( 28.10. )', NULL, 0, 66),
(176, '0000-11-17', NULL, 'Státní svátek', 'Den boje za svobodu a demokracii ( 17.11. )', NULL, 0, 66),
(177, '0000-12-24', NULL, 'Státní svátek', 'Štědrý den ( 24.12. )', NULL, 0, 66),
(178, '0000-12-25', NULL, 'Státní svátek', '1. svátek vánoční ( 25.12. )', NULL, 0, 66),
(179, '0000-12-26', NULL, 'Státní svátek', '2. svátek vánoční ( 26.12. )', NULL, 0, 66),
(180, '0000-01-01', NULL, 'Státní svátek', 'Den obnovy samostatného českého státu ( 1.1. )', NULL, 0, 67),
(181, '0000-05-01', NULL, 'Státní svátek', 'Svátek práce ( 1.5. )', NULL, 0, 67),
(182, '0000-04-21', NULL, 'Státní svátek', 'Velikonoční pondělí ( 21.4. )', NULL, 0, 67),
(183, '0000-05-08', NULL, 'Státní svátek', 'Den vítězství ( 8.5. )', NULL, 0, 67),
(184, '0000-07-05', NULL, 'Státní svátek', 'Den slovanských věrozvěstů Cyrila a Metoděje ( 5.7. )', NULL, 0, 67),
(185, '0000-07-06', NULL, 'Státní svátek', 'Den upálení mistra Jana Husa ( 6.7. )', NULL, 0, 67),
(186, '0000-09-28', NULL, 'Státní svátek', 'Den české státnosti ( 28.9. )', NULL, 0, 67),
(187, '0000-10-28', NULL, 'Státní svátek', 'Den vzniku samostatného československého státu ( 28.10. )', NULL, 0, 67),
(188, '0000-11-17', NULL, 'Státní svátek', 'Den boje za svobodu a demokracii ( 17.11. )', NULL, 0, 67),
(189, '0000-12-24', NULL, 'Státní svátek', 'Štědrý den ( 24.12. )', NULL, 0, 67),
(190, '0000-12-25', NULL, 'Státní svátek', '1. svátek vánoční ( 25.12. )', NULL, 0, 67),
(191, '0000-12-26', NULL, 'Státní svátek', '2. svátek vánoční ( 26.12. )', NULL, 0, 67),
(204, '0000-01-01', NULL, 'Státní svátek', 'Den obnovy samostatného českého státu ( 1.1. )', NULL, 0, 69),
(205, '0000-05-01', NULL, 'Státní svátek', 'Svátek práce ( 1.5. )', NULL, 0, 69),
(206, '0000-04-21', NULL, 'Státní svátek', 'Velikonoční pondělí ( 21.4. )', NULL, 0, 69),
(207, '0000-05-08', NULL, 'Státní svátek', 'Den vítězství ( 8.5. )', NULL, 0, 69),
(208, '0000-07-05', NULL, 'Státní svátek', 'Den slovanských věrozvěstů Cyrila a Metoděje ( 5.7. )', NULL, 0, 69),
(209, '0000-07-06', NULL, 'Státní svátek', 'Den upálení mistra Jana Husa ( 6.7. )', NULL, 0, 69),
(210, '0000-09-28', NULL, 'Státní svátek', 'Den české státnosti ( 28.9. )', NULL, 0, 69),
(211, '0000-10-28', NULL, 'Státní svátek', 'Den vzniku samostatného československého státu ( 28.10. )', NULL, 0, 69),
(212, '0000-11-17', NULL, 'Státní svátek', 'Den boje za svobodu a demokracii ( 17.11. )', NULL, 0, 69),
(213, '0000-12-24', NULL, 'Státní svátek', 'Štědrý den ( 24.12. )', NULL, 0, 69),
(214, '0000-12-25', NULL, 'Státní svátek', '1. svátek vánoční ( 25.12. )', NULL, 0, 69),
(215, '0000-12-26', NULL, 'Státní svátek', '2. svátek vánoční ( 26.12. )', NULL, 0, 69),
(216, '0000-01-01', NULL, 'Státní svátek', 'Den obnovy samostatného českého státu ( 1.1. )', NULL, 0, 70),
(217, '0000-05-01', NULL, 'Státní svátek', 'Svátek práce ( 1.5. )', NULL, 0, 70),
(218, '0000-04-21', NULL, 'Státní svátek', 'Velikonoční pondělí ( 21.4. )', NULL, 0, 70),
(219, '0000-05-08', NULL, 'Státní svátek', 'Den vítězství ( 8.5. )', NULL, 0, 70),
(220, '0000-07-05', NULL, 'Státní svátek', 'Den slovanských věrozvěstů Cyrila a Metoděje ( 5.7. )', NULL, 0, 70),
(221, '0000-07-06', NULL, 'Státní svátek', 'Den upálení mistra Jana Husa ( 6.7. )', NULL, 0, 70),
(222, '0000-09-28', NULL, 'Státní svátek', 'Den české státnosti ( 28.9. )', NULL, 0, 70),
(223, '0000-10-28', NULL, 'Státní svátek', 'Den vzniku samostatného československého státu ( 28.10. )', NULL, 0, 70),
(224, '0000-11-17', NULL, 'Státní svátek', 'Den boje za svobodu a demokracii ( 17.11. )', NULL, 0, 70),
(225, '0000-12-24', NULL, 'Státní svátek', 'Štědrý den ( 24.12. )', NULL, 0, 70),
(226, '0000-12-25', NULL, 'Státní svátek', '1. svátek vánoční ( 25.12. )', NULL, 0, 70),
(227, '0000-12-26', NULL, 'Státní svátek', '2. svátek vánoční ( 26.12. )', NULL, 0, 70),
(229, '2014-12-15', NULL, 'Dovolená', '', NULL, 0, 64),
(230, '2014-12-16', NULL, 'Dovolená', '', NULL, 0, 64),
(231, '2014-12-16', NULL, 'Dovolená', '', NULL, 0, 64),
(232, '2014-12-16', NULL, 'Dovolená', '', NULL, 0, 64),
(233, '2014-12-16', NULL, 'Dovolená', '', NULL, 0, 64),
(234, '2014-12-16', NULL, 'Dovolená', '', NULL, 0, 64),
(235, '0000-01-01', NULL, 'Státní svátek', 'Den obnovy samostatného českého státu ( 1.1. )', NULL, 0, 71),
(236, '0000-05-01', NULL, 'Státní svátek', 'Svátek práce ( 1.5. )', NULL, 0, 71),
(237, '0000-04-21', NULL, 'Státní svátek', 'Velikonoční pondělí ( 21.4. )', NULL, 0, 71),
(238, '0000-05-08', NULL, 'Státní svátek', 'Den vítězství ( 8.5. )', NULL, 0, 71),
(239, '0000-07-05', NULL, 'Státní svátek', 'Den slovanských věrozvěstů Cyrila a Metoděje ( 5.7. )', NULL, 0, 71),
(240, '0000-07-06', NULL, 'Státní svátek', 'Den upálení mistra Jana Husa ( 6.7. )', NULL, 0, 71),
(241, '0000-09-28', NULL, 'Státní svátek', 'Den české státnosti ( 28.9. )', NULL, 0, 71),
(242, '0000-10-28', NULL, 'Státní svátek', 'Den vzniku samostatného československého státu ( 28.10. )', NULL, 0, 71),
(243, '0000-11-17', NULL, 'Státní svátek', 'Den boje za svobodu a demokracii ( 17.11. )', NULL, 0, 71),
(244, '0000-12-24', NULL, 'Státní svátek', 'Štědrý den ( 24.12. )', NULL, 0, 71),
(245, '0000-12-25', NULL, 'Státní svátek', '1. svátek vánoční ( 25.12. )', NULL, 0, 71),
(246, '0000-12-26', NULL, 'Státní svátek', '2. svátek vánoční ( 26.12. )', NULL, 0, 71),
(247, '2014-12-17', '2014-12-18', 'Dovolená', '', NULL, 0, 71),
(248, '2014-12-17', NULL, 'Závodní dovolená', '', 42, 0, 64),
(250, '2014-12-17', '2014-12-18', 'Dovolená', '', NULL, 0, 64),
(251, '0000-01-01', NULL, 'Státní svátek', 'Den obnovy samostatného českého státu ( 1.1. )', NULL, 0, 72),
(252, '0000-05-01', NULL, 'Státní svátek', 'Svátek práce ( 1.5. )', NULL, 0, 72),
(253, '0000-04-21', NULL, 'Státní svátek', 'Velikonoční pondělí ( 21.4. )', NULL, 0, 72),
(254, '0000-05-08', NULL, 'Státní svátek', 'Den vítězství ( 8.5. )', NULL, 0, 72),
(255, '0000-07-05', NULL, 'Státní svátek', 'Den slovanských věrozvěstů Cyrila a Metoděje ( 5.7. )', NULL, 0, 72),
(256, '0000-07-06', NULL, 'Státní svátek', 'Den upálení mistra Jana Husa ( 6.7. )', NULL, 0, 72),
(257, '0000-09-28', NULL, 'Státní svátek', 'Den české státnosti ( 28.9. )', NULL, 0, 72),
(258, '0000-10-28', NULL, 'Státní svátek', 'Den vzniku samostatného československého státu ( 28.10. )', NULL, 0, 72),
(259, '0000-11-17', NULL, 'Státní svátek', 'Den boje za svobodu a demokracii ( 17.11. )', NULL, 0, 72),
(260, '0000-12-24', NULL, 'Státní svátek', 'Štědrý den ( 24.12. )', NULL, 0, 72),
(261, '0000-12-25', NULL, 'Státní svátek', '1. svátek vánoční ( 25.12. )', NULL, 0, 72),
(262, '0000-12-26', NULL, 'Státní svátek', '2. svátek vánoční ( 26.12. )', NULL, 0, 72),
(264, '2015-01-01', NULL, 'Dovolená', '', NULL, 0, 64),
(269, '2015-01-29', NULL, 'Dovolená', '', NULL, 0, 64),
(270, '2015-01-24', NULL, 'Dovolená', '', NULL, 0, 64),
(272, '2015-01-06', NULL, 'Dovolená', '', NULL, 0, 64),
(273, '2015-01-12', NULL, 'Dovolená', '', NULL, 0, 64),
(276, '2015-01-22', NULL, 'Dovolená', '', NULL, 0, 64);

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `ukoly`
--
ALTER TABLE `ukoly`
  ADD CONSTRAINT `fk_ukoly_spolecnost1` FOREIGN KEY (`spolecnost_idspolecnost`) REFERENCES `spolecnost` (`idspolecnost`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Omezení pro tabulku `uzivatele`
--
ALTER TABLE `uzivatele`
  ADD CONSTRAINT `fk_uzivatele_spolecnost1` FOREIGN KEY (`spolecnost_idspolecnost`) REFERENCES `spolecnost` (`idspolecnost`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `volno`
--
ALTER TABLE `volno`
  ADD CONSTRAINT `fk_volno_uzivatele1` FOREIGN KEY (`uzivatele_iduzivatele`) REFERENCES `uzivatele` (`iduzivatele`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
