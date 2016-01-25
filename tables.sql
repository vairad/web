-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Stř 14. led 2015, 10:19
-- Verze serveru: 5.6.17
-- Verze PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `pivko`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `hry`
--

CREATE TABLE IF NOT EXISTS `hry` (
  `id_hry` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(60) NOT NULL,
  `popis` text NOT NULL,
  `delka` int(11) NOT NULL,
  `cena` int(11) NOT NULL,
  `pocet_m` int(11) NOT NULL,
  `pocet_z` int(11) NOT NULL,
  `pocet_h` int(11) NOT NULL,
  `min` int(11) NOT NULL,
  `organizator` int(11) NOT NULL,
  `web` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_hry`),
  UNIQUE KEY `nazev` (`nazev`),
  KEY `fk_hry_osoby1_idx` (`organizator`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Vyprázdnit tabulku před vkládáním `hry`
--

TRUNCATE TABLE `hry`;
--
-- Vypisuji data pro tabulku `hry`
--

INSERT INTO `hry` (`id_hry`, `nazev`, `popis`, `delka`, `cena`, `pocet_m`, `pocet_z`, `pocet_h`, `min`, `organizator`, `web`) VALUES
(1, 'Bez keců', 'asof aspfjapwfh aqh půafh pqwofh  qwpfj qpof qpoefh qewpog', 50, 60, 1, 2, 8, 0, 1, ''),
(3, 'Pineapple', 'apfoja fqw fqwúofs fasjfpofjpof pof ewiphfwe fweifhewfhewépfi ewhfih fiphiewfiowhf oewifhif hewiofhew io fwhiofhewofhewofhewofhwofw iofh iowhfiohf iofh ioh wfhiowoiwfihw fioew fioapfoja fqw fqwúofs fasjfpofjpof pof ewiphfwe fweifhewfhewépfi ewhfih fiphiewfiowhf oewifhif hewiofhew io fwhiofhewofhewofhewofhwofw iofh iowhfiohf iofh ioh wfhiowoiwfihw fioew fioapfoja fqw fqwúofs fasjfpofjpof pof ewiphfwe fweifhewfhewépfi ewhfih fiphiewfiowhf oewifhif hewiofhew io fwhiofhewofhewofhewofhwofw iofh iowhfiohf iofh ioh wfhiowoiwfihw fioew fioapfoja fqw fqwúofs fasjfpofjpof pof ewiphfwe fweifhewfhewépfi ewhfih fiphiewfiowhf oewifhif hewiofhew io fwhiofhewofhewofhewofhwofw iofh iowhfiohf iofh ioh wfhiowoiwfihw fioew fioapfoja fqw fqwúofs fasjfpofjpof pof ewiphfwe fweifhewfhewépfi ewhfih fiphiewfiowhf oewifhif hewiofhew io fwhiofhewofhewofhewofhwofw iofh iowhfiohf iofh ioh wfhiowoiwfihw fioew fioapfoja fqw fqwúofs fasjfpofjpof pof ewiphfwe fweifhewfhewépfi ewhfih fiphiewfiowhf oewifhif hewiofhew io fwhiofhewofhewofhewofhwofw iofh iowhfiohf iofh ioh wfhiowoiwfihw fioew fioapfoja fqw fqwúofs fasjfpofjpof pof ewiphfwe fweifhewfhewépfi ewhfih fiphiewfiowhf oewifhif hewiofhew io fwhiofhewofhewofhewofhwofw iofh iowhfiohf iofh ioh wfhiowoiwfihw fioew fioapfoja fqw fqwúofs fasjfpofjpof pof ewiphfwe fweifhewfhewépfi ewhfih fiphiewfiowhf oewifhif hewiofhew io fwhiofhewofhewofhewofhwofw iofh iowhfiohf iofh ioh wfhiowoiwfihw fioew fio', 10, 10, 3, 3, 3, 9, 1, NULL),
(5, 'Pragma twice game', 'apogf aúpfona púoqwngfú njfúqwo úqofj qúwofj', 180, 5, 9, 8, 7, 0, 1, 'nic nebude'),
(7, 'Testovací paušál', 'Anotace hry tři tečky', 6, 6, 6, 6, 6, 6, 13, 'není'),
(8, 'Jednomuzna', 'Hluboký popis hry', 50, 50, 1, 0, 0, 1, 1, 'web hry'),
(9, 'Nová hra', 'Anotace', 50, 2, 7, 8, 9, 4, 13, 'není'),
(10, 'Nvá hra odevz', 'anotace', 50, 50, 1, 2, 3, 0, 13, 'není');

-- --------------------------------------------------------

--
-- Struktura tabulky `mista`
--

CREATE TABLE IF NOT EXISTS `mista` (
  `id_mista` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(60) NOT NULL,
  `ulice` varchar(100) NOT NULL,
  `cp` int(11) DEFAULT NULL,
  `gps` varchar(45) NOT NULL,
  `popis` text NOT NULL,
  `kapacita` int(11) NOT NULL,
  PRIMARY KEY (`id_mista`),
  UNIQUE KEY `nazev` (`nazev`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Vyprázdnit tabulku před vkládáním `mista`
--

TRUNCATE TABLE `mista`;
--
-- Vypisuji data pro tabulku `mista`
--

INSERT INTO `mista` (`id_mista`, `nazev`, `ulice`, `cp`, `gps`, `popis`, `kapacita`) VALUES
(11, 'Seraf', 'Malá', 15, '49°45''40.190"N, 13°25''36.273"E', 'Cože proč ne? jakže', 1),
(12, 'Senečák', 'Senecký rybník', NULL, '49°45''40.190"N, 13°25''36.273"E', 'aposifnqw qwpgo qwe poqjewg qpewo jqewúogj qwogfj pqewoj pqofj pqowfj qpwofj pqwfj qwpfojeqwpogf w\\€pf wqpgfjwqepof jwepojpew pewof ojg pwqjwowgi efin wpgj wpgj wpgje gijw pgj apgj pwijg pwigj wpgjew gpwjg pihg sgo po.', 5),
(13, 'Byt bory2', 'Dvorakova', 98, '49°45''40.190"N, 13°25''36.273"E', 'apfsojapj púa sdfafpoqwj poqj pwojqwpo qwpfojpowj pojqfjqfpqo sjfqpoj pjqpj apfsojapj púa sdfafpoqwj poqj pwojqwpo qwpfojpowj pojqfjqfpqo sjfqpoj pjqpj apfsojapj púa sdfafpoqwj poqj pwojqwpo qwpfojpowj pojqfjqfpqo sjfqpoj pjqpj apfsojapj púa sdfafpoqwj poqj pwojqwpo qwpfojpowj pojqfjqfpqo sjfqpoj pjqpj apfsojapj púa sdfafpoqwj poqj pwojqwpo qwpfojpowj pojqfjqfpqo sjfqpoj pjqpj apfsojapj púa sdfafpoqwj poqj pwojqwpo qwpfojpowj pojqfjqfpqo sjfqpoj pjqpj apfsojapj púa sdfafpoqwj poqj pwojqwpo qwpfojpowj pojqfjqfpqo sjfqpoj pjqpj apfsojapj púa sdfafpoqwj poqj pwojqwpo qwpfojpowj pojqfjqfpqo sjfqpoj pjqpj apfsojapj púa sdfafpoqwj poqj pwojqwpo qwpfojpowj pojqfjqfpqo sjfqpoj pjqpj apfsojapj púa sdfafpoqwj poqj pwojqwpo qwpfojpowj pojqfjqfpqo sjfqpoj pjqpj apfsojapj púa sdfafpoqwj poqj pwojqwpo qwpfojpowj pojqfjqfpqo sjfqpoj pjqpj apfsojapj púa sdfafpoqwj poqj pwojqwpo qwpfojpowj pojqfjqfpqo sjfqpoj pjqpj apfsojapj púa sdfafpoqwj poqj pwojqwpo qwpfojpowj pojqfjqfpqo sjfqpoj pjqpj apfsojapj púa sdfafpoqwj poqj pwojqwpo qwpfojpowj pojqfjqfpqo sjfqpoj pjqpj apfsojapj púa sdfafpoqwj poqj pwojqwpo qwpfojpowj pojqfjqfpqo sjfqpoj pjqpj apfsojapj púa sdfafpoqwj poqj pwojqwpo qwpfojpowj pojqfjqfpqo sjfqpoj pjqpj', 5),
(14, 'Černice', 'vstupní', 26, '49°45''40.190"N, 13°25''36.273"E', 'pfxojasfpa fojaf=éjqw f´éwqejf qw=féjwf =éfj =fj f=éqw f=qwfqwe=f qew=fjw=fjw=fj =jqw f=qwjfqw=éfjw=éfjw= fewj=f ewjfew= fjew=fjew=fwe=éfjew ewéfjew=éfj =ewéjw =féj =ewéjfwe=fjwe=f ew=f ew=fjew=fj ew=fw=f', 1),
(15, 'Pragma', 'Skalní', 65, '49°45''40.190"N, 13°25''36.273"E', 'Náhodný lorem člověk generovaný text', 5),
(16, 'Pragma twice', 'Druztová', 56, '49°45''40.190"N, 13°25''36.273"E', 'Popois místa dopravy a tak', 8),
(17, 'Nové místo', 'Kdesi', 10, '49°44''38.228"N, 13°22''43.680"E', 'Lorem ipsum', 5);

-- --------------------------------------------------------

--
-- Struktura tabulky `osoby`
--

CREATE TABLE IF NOT EXISTS `osoby` (
  `id_osoby` int(11) NOT NULL AUTO_INCREMENT,
  `jmeno` varchar(45) NOT NULL,
  `prijmeni` varchar(45) NOT NULL,
  `prezdivka` varchar(45) DEFAULT NULL,
  `datnar` date NOT NULL,
  `pohlavi` tinyint(1) NOT NULL,
  `email` varchar(60) NOT NULL,
  `mobil` int(11) NOT NULL,
  `heslo` varchar(40) NOT NULL,
  `posledni` datetime DEFAULT NULL,
  `vytvoreni` datetime DEFAULT NULL,
  `typuctu` int(11) DEFAULT '1',
  PRIMARY KEY (`id_osoby`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Vyprázdnit tabulku před vkládáním `osoby`
--

TRUNCATE TABLE `osoby`;
--
-- Vypisuji data pro tabulku `osoby`
--

INSERT INTO `osoby` (`id_osoby`, `jmeno`, `prijmeni`, `prezdivka`, `datnar`, `pohlavi`, `email`, `mobil`, `heslo`, `posledni`, `vytvoreni`, `typuctu`) VALUES
(1, 'Radek', 'Siav', 'Admin', '2001-06-01', 1, 'david@davic.cz', 123456789, '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, NULL, 99),
(3, 'Radek', 'Siav', 'Orrg1', '1993-06-01', 1, 'david@davic.cz22', 123456789, '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, NULL, 50),
(5, 'Radek', 'Siav', 'Org2', '2001-06-01', 1, 'david@davic.cz123', 123456789, '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, NULL, 50),
(13, 'Radek', 'Siav', 'Org3', '2001-06-01', 1, 'david@davic.cz1234', 123456789, '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, NULL, 50),
(16, 'Radek', 'Siav', 'Devig', '2001-06-01', 1, 'david@davic.cz12345', 123456789, '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, NULL, 1),
(17, 'Radek', 'Siav', 'Devig', '2001-06-01', 1, 'david@davic.cz123458', 123456789, '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, NULL, 1),
(19, 'Radek', 'Siav', 'Devig', '2001-06-01', 1, 'david@davic.cz1234589', 123456789, '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, NULL, 1),
(20, 'František', 'Polívka', 'Gym', '1990-01-01', 1, 'dk@gmb.dk', 123456789, '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, '2014-12-09 11:44:23', 1),
(21, 'Alex', 'Baldwin', 'Badger', '1980-01-01', 0, 'alex@mail.c', 123456789, '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, '2014-12-09 12:48:13', 1),
(22, 'Písař', 'Matěj', 'asofin', '1965-01-01', 0, '123@12.cz', 123456789, '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, '2014-12-09 12:52:50', 1),
(23, 'Mirek', 'Dušín', 'lob', '1991-01-01', 1, 'dub@dub.cz', 123456789, '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, '2015-01-12 14:03:42', 1),
(24, 'Dalibor', 'Pravda', 'Poslední', '1989-01-01', 1, 'dal@nedal.cz', 123456789, '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, '2015-01-13 23:00:43', 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `prihlasky`
--

CREATE TABLE IF NOT EXISTS `prihlasky` (
  `cas` datetime DEFAULT NULL,
  `hrac` int(11) NOT NULL,
  `uvedeni` int(11) NOT NULL,
  PRIMARY KEY (`hrac`,`uvedeni`),
  KEY `fk_prihlasky_osoby_idx` (`hrac`),
  KEY `fk_prihlasky_uvedeni1_idx` (`uvedeni`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vyprázdnit tabulku před vkládáním `prihlasky`
--

TRUNCATE TABLE `prihlasky`;
--
-- Vypisuji data pro tabulku `prihlasky`
--

INSERT INTO `prihlasky` (`cas`, `hrac`, `uvedeni`) VALUES
(NULL, 1, 7),
(NULL, 1, 8),
(NULL, 1, 13),
(NULL, 1, 17),
(NULL, 1, 23),
(NULL, 13, 7),
(NULL, 13, 17),
(NULL, 13, 27),
(NULL, 13, 29),
(NULL, 22, 7),
(NULL, 23, 26),
(NULL, 23, 27),
(NULL, 24, 7),
(NULL, 24, 25);

-- --------------------------------------------------------

--
-- Struktura tabulky `rocnik`
--

CREATE TABLE IF NOT EXISTS `rocnik` (
  `id_rocnik` int(11) NOT NULL AUTO_INCREMENT,
  `zacatek` date NOT NULL,
  `konec` date NOT NULL,
  PRIMARY KEY (`id_rocnik`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Vyprázdnit tabulku před vkládáním `rocnik`
--

TRUNCATE TABLE `rocnik`;
--
-- Vypisuji data pro tabulku `rocnik`
--

INSERT INTO `rocnik` (`id_rocnik`, `zacatek`, `konec`) VALUES
(1, '2015-02-27', '2015-03-01');

-- --------------------------------------------------------

--
-- Struktura tabulky `uvedeni`
--

CREATE TABLE IF NOT EXISTS `uvedeni` (
  `id_uvedeni` int(11) NOT NULL AUTO_INCREMENT,
  `zacatek` datetime NOT NULL,
  `misto` int(11) NOT NULL,
  `rocnik` int(11) NOT NULL DEFAULT '1',
  `hra` int(11) NOT NULL,
  `flag` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_uvedeni`),
  KEY `fk_uvedeni_mista1_idx` (`misto`),
  KEY `fk_uvedeni_rocnik1_idx` (`rocnik`),
  KEY `fk_uvedeni_hry1_idx` (`hra`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Vyprázdnit tabulku před vkládáním `uvedeni`
--

TRUNCATE TABLE `uvedeni`;
--
-- Vypisuji data pro tabulku `uvedeni`
--

INSERT INTO `uvedeni` (`id_uvedeni`, `zacatek`, `misto`, `rocnik`, `hra`, `flag`) VALUES
(7, '2015-02-21 01:12:00', 11, 1, 1, 0),
(8, '2015-02-28 15:15:00', 14, 1, 3, 0),
(13, '2015-02-28 18:20:00', 13, 1, 3, 0),
(17, '2015-02-25 04:39:00', 12, 1, 1, 0),
(23, '2015-02-21 00:00:00', 16, 1, 5, 0),
(25, '2015-02-27 15:16:00', 14, 1, 5, 0),
(26, '2015-02-28 10:11:00', 16, 1, 8, 0),
(27, '2015-02-27 12:55:00', 13, 1, 9, 0),
(28, '2015-02-27 14:52:00', 17, 1, 9, 0),
(29, '2015-02-28 11:11:00', 15, 1, 10, 0);

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `hry`
--
ALTER TABLE `hry`
  ADD CONSTRAINT `fk_hry_osoby1` FOREIGN KEY (`organizator`) REFERENCES `osoby` (`id_osoby`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Omezení pro tabulku `prihlasky`
--
ALTER TABLE `prihlasky`
  ADD CONSTRAINT `fk_prihlasky_osoby` FOREIGN KEY (`hrac`) REFERENCES `osoby` (`id_osoby`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_prihlasky_uvedeni1` FOREIGN KEY (`uvedeni`) REFERENCES `uvedeni` (`id_uvedeni`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Omezení pro tabulku `uvedeni`
--
ALTER TABLE `uvedeni`
  ADD CONSTRAINT `fk_uvedeni_hry1` FOREIGN KEY (`hra`) REFERENCES `hry` (`id_hry`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_uvedeni_mista1` FOREIGN KEY (`misto`) REFERENCES `mista` (`id_mista`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_uvedeni_rocnik1` FOREIGN KEY (`rocnik`) REFERENCES `rocnik` (`id_rocnik`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
