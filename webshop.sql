-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Machine: localhost
-- Genereertijd: 01 okt 2013 om 07:58
-- Serverversie: 5.5.24-log
-- PHP-versie: 5.4.3

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
(2, 'Timon', 'de', 'Groot', '8271 JA', 'Aalbershof', 30, 'IJsselmuiden');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `categorieën`
--

CREATE TABLE IF NOT EXISTS `categorieën` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Naam` varchar(15) NOT NULL,
  `parentid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `Naam` int(11) NOT NULL,
  `parentid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
