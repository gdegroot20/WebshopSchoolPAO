-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Machine: 127.0.0.1
-- Genereertijd: 09 dec 2013 om 10:30
-- Serverversie: 5.5.27
-- PHP-versie: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `webshop`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Password` varchar(999) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `profile` int(11) NOT NULL,
  `Serial` varchar(999) NOT NULL,
  `Activated` tinyint(1) NOT NULL COMMENT '(T)rue or (False)',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Gegevens worden uitgevoerd voor tabel `accounts`
--

INSERT INTO `accounts` (`id`, `Password`, `Email`, `profile`, `Serial`, `Activated`) VALUES
(2, '21232f297a57a5a743894a0e4a801fc3', 'admin@admin.nl', 1, '', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `adressen`
--

CREATE TABLE IF NOT EXISTS `adressen` (
  `accountid` int(11) NOT NULL,
  `Voornaam` varchar(15) NOT NULL,
  `Tussenvoegsel` varchar(10) NOT NULL,
  `Achternaam` varchar(15) NOT NULL,
  `Postcode` varchar(7) NOT NULL,
  `Straatnaam` varchar(20) NOT NULL,
  `Huisnummer` int(11) NOT NULL,
  `Plaats` varchar(20) NOT NULL,
  PRIMARY KEY (`accountid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden uitgevoerd voor tabel `adressen`
--

INSERT INTO `adressen` (`accountid`, `Voornaam`, `Tussenvoegsel`, `Achternaam`, `Postcode`, `Straatnaam`, `Huisnummer`, `Plaats`) VALUES
(2, 'Gerrit', 'de', 'Groot', '8095PL', 'Vreeweg', 83, 'Oldebroek');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bestellingen`
--

CREATE TABLE IF NOT EXISTS `bestellingen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accountid` int(11) NOT NULL,
  `Producten` text NOT NULL,
  `BestelDag` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Gegevens worden uitgevoerd voor tabel `bestellingen`
--

INSERT INTO `bestellingen` (`id`, `accountid`, `Producten`, `BestelDag`) VALUES
(1, 2, '1,10;2,11', '2013-10-24'),
(2, 2, '1,2;2,16', '2013-10-10'),
(3, 2, '1,1;2,1', '2013-11-04'),
(4, 2, '1,1', '2013-11-13'),
(5, 2, '1,1;2,1', '2013-11-13'),
(6, 2, '1,1;2,1', '2013-11-13'),
(7, 2, '1,1;2,1', '2013-11-13'),
(8, 2, '1,1;2,1', '2013-11-13'),
(9, 2, '1,1', '2013-11-18'),
(10, 2, '1,1', '2013-11-18'),
(12, 2, '2,1;1,1', '2013-11-20'),
(14, 2, '2,1', '2013-11-20'),
(15, 2, '2,1', '2013-11-20'),
(17, 2, '1,1;2,1', '2013-11-20'),
(18, 2, '1,1;2,1', '2013-11-20'),
(19, 2, '1,1;2,1', '2013-11-20'),
(20, 2, '1,1;2,1', '2013-11-20');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `categorieën`
--

CREATE TABLE IF NOT EXISTS `categorieën` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Naam` varchar(15) NOT NULL,
  `parentid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Gegevens worden uitgevoerd voor tabel `categorieën`
--

INSERT INTO `categorieën` (`id`, `Naam`, `parentid`) VALUES
(1, 'heren schoenen', 0),
(2, 'dames schoenen', 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `producten`
--

CREATE TABLE IF NOT EXISTS `producten` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Naam` varchar(15) NOT NULL,
  `Omschrijving` text NOT NULL,
  `Prijs` int(11) NOT NULL,
  `Voorraad` int(11) NOT NULL,
  `parentid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Gegevens worden uitgevoerd voor tabel `producten`
--

INSERT INTO `producten` (`id`, `Naam`, `Omschrijving`, `Prijs`, `Voorraad`, `parentid`) VALUES
(1, 'g', 'g', 2, 2, 1),
(2, 'schoen', 'schoen', 50, 0, 1),
(3, 'gg', 'gggg', 10, 10, 2),
(4, 'groenen', 'geniaal', 24, 24, 1),
(5, 'schenen', 'gg', 10, 10, 0),
(8, 'e', 'e', 1, 1, 0),
(9, 'e', 'e', 1, 1, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `profiles`
--

CREATE TABLE IF NOT EXISTS `profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profile` int(11) NOT NULL COMMENT '0=normal, 1=admin',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `subcategorieën`
--

CREATE TABLE IF NOT EXISTS `subcategorieën` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Naam` varchar(11) NOT NULL,
  `parentid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Gegevens worden uitgevoerd voor tabel `subcategorieën`
--

INSERT INTO `subcategorieën` (`id`, `Naam`, `parentid`) VALUES
(1, 'nike', 1),
(2, '0xcvxc', 1),
(3, 'xcvxc', 1),
(4, '0xccxv', 1),
(5, 'cxvxcv', 1),
(6, '0xcvxc', 1),
(7, '0ffds', 2),
(8, 'bcxxb', 2),
(9, '0ff', 2),
(10, '0sdfsd', 1),
(11, '0f', 1),
(12, '0sdaf', 1),
(13, 'asdf', 1),
(14, 'werf', 1),
(15, 'schoen', 1),
(16, 'adidas', 2),
(17, 'sports', 2),
(18, '0xcv', 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
