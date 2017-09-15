-- phpMyAdmin SQL Dump
-- version 3.3.7deb7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 24, 2014 at 12:46 PM
-- Server version: 5.0.51
-- PHP Version: 5.3.3-7+squeeze19

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `WebDiP2013_096`
--

-- --------------------------------------------------------

--
-- Table structure for table `aktivnost`
--

CREATE TABLE IF NOT EXISTS `aktivnost` (
  `idaktivnosti` int(11) NOT NULL auto_increment,
  `naziv` varchar(20) collate utf8_slovenian_ci NOT NULL,
  PRIMARY KEY  (`idaktivnosti`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `aktivnost`
--

INSERT INTO `aktivnost` (`idaktivnosti`, `naziv`) VALUES
(1, 'Uspjesna prijava'),
(2, 'Neuspjesna prijava'),
(3, 'Kupnja karte'),
(4, 'Izdavanje kazne'),
(5, 'Podmirivanje kazne'),
(6, 'Odjava');

-- --------------------------------------------------------

--
-- Table structure for table `karta`
--

CREATE TABLE IF NOT EXISTS `karta` (
  `idkarte` int(11) NOT NULL auto_increment,
  `cijena` float NOT NULL,
  `pocetak` date default NULL,
  `kraj` date default NULL,
  `vozilo` int(11) NOT NULL,
  `parking` int(11) NOT NULL,
  `kod` int(11) NOT NULL,
  PRIMARY KEY  (`idkarte`),
  KEY `fk_karta_vozilo1_idx` (`vozilo`),
  KEY `fk_karta_parking1_idx` (`parking`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `karta`
--

INSERT INTO `karta` (`idkarte`, `cijena`, `pocetak`, `kraj`, `vozilo`, `parking`, `kod`) VALUES
(25, 400, '2014-06-21', '2014-07-21', 11, 3, 0),
(26, 40, '2014-06-21', '2014-06-22', 11, 5, 0),
(27, 40, '2014-06-21', '2014-06-22', 12, 5, 0),
(28, 500, '2014-06-21', '2014-07-21', 10, 4, 0),
(32, 300, '2014-06-23', '2014-07-23', 10, 1, 0),
(34, 50, '2014-06-23', '2014-06-23', 11, 4, 0),
(42, 300, '2014-06-29', '2014-07-29', 2, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `kazna`
--

CREATE TABLE IF NOT EXISTS `kazna` (
  `idkazne` int(11) NOT NULL auto_increment,
  `cijena` float default NULL,
  `vrijeme` datetime default NULL,
  `vozilo` int(11) NOT NULL,
  `parking` int(11) NOT NULL,
  `izdao` int(11) NOT NULL,
  `napomena` text collate utf8_slovenian_ci NOT NULL,
  `placeno` date default NULL,
  PRIMARY KEY  (`idkazne`),
  KEY `fk_kazna_vozilo1_idx` (`vozilo`),
  KEY `fk_kazna_parking1_idx` (`parking`),
  KEY `fk_kazna_izdao1_idx` (`izdao`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `kazna`
--

INSERT INTO `kazna` (`idkazne`, `cijena`, `vrijeme`, `vozilo`, `parking`, `izdao`, `napomena`, `placeno`) VALUES
(1, 100, '2014-06-21 17:45:43', 9, 2, 1, 'Ovo je prva kazna za 9876', '0000-00-00'),
(2, 100, '2014-06-21 17:46:18', 13, 5, 1, 'Ovo je druga kazna za 5634', '2014-06-27'),
(3, 100, '2014-06-21 18:26:21', 12, 3, 1, 'Ovo je kazna za 254', '2014-06-23'),
(4, 100, '2014-06-22 22:57:27', 12, 5, 1, 'Kazna za 254', '2014-06-22'),
(8, 28, '2014-06-23 13:45:20', 3, 5, 1, 'Kazna za 1234', '0000-00-00'),
(9, 16, '2014-06-23 17:18:53', 4, 3, 1, 'Ovo je kazna za 1331', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

CREATE TABLE IF NOT EXISTS `korisnik` (
  `idkorisnika` int(11) NOT NULL auto_increment,
  `ime` varchar(20) character set utf8 NOT NULL,
  `prezime` varchar(40) character set utf8 NOT NULL,
  `korisnicko` varchar(20) character set utf8 NOT NULL,
  `lozinka` varchar(20) character set utf8 NOT NULL,
  `adresa` varchar(50) character set utf8 NOT NULL,
  `grad` varchar(30) character set utf8 default NULL,
  `email` varchar(30) character set latin1 default NULL,
  `telefon` varchar(20) collate utf8_slovenian_ci NOT NULL,
  `tip` int(11) NOT NULL,
  `aktivan` int(11) NOT NULL,
  `kod` int(11) NOT NULL,
  `vrijeme` datetime NOT NULL,
  PRIMARY KEY  (`idkorisnika`),
  KEY `fk_korisnik_tip_korisnika1_idx` (`tip`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=34 ;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`idkorisnika`, `ime`, `prezime`, `korisnicko`, `lozinka`, `adresa`, `grad`, `email`, `telefon`, `tip`, `aktivan`, `kod`, `vrijeme`) VALUES
(1, 'Nino', 'Å½vorc', 'nzvorc', 'admin', 'Pavlinska 1', 'ÄŒakovec', 'nzvorc@foi.hr', '098 124 1546', 1, 1, 1, '0000-00-00 00:00:00'),
(2, 'Matej', 'VukoviÄ‡', 'mvukovic', 'mvuk', 'Pavlinska 2', 'Slunj', 'mvuk@foi.hr', '095 026 4788', 2, 1, 0, '0000-00-00 00:00:00'),
(3, 'Goran', 'Vodomin', 'gvodomin', 'gvod', 'Pavlinska 3', 'Koprivnica', 'gvod@foi.hr', '098 897 2154', 2, 1, 0, '0000-00-00 00:00:00'),
(4, 'Martina', 'Å estak', 'msestak', 'mses', 'Pavlinska 4', 'VaraÅ¾din', 'mses@foi.hr', '098 693 2541', 2, 1, 0, '0000-00-00 00:00:00'),
(5, 'Ivan', 'Å peranda', 'isperanda', 'isper', 'Pavlinska 5', 'Osijek', 'isper@foi.hr', '095 061 9874', 2, 1, 0, '0000-00-00 00:00:00'),
(6, 'Kristijan', 'Å tokan', 'kstokan', 'kstok', 'Pavlinska 6', 'Äakovo', 'kstok@foi.hr', '097 614 7871', 2, 1, 0, '0000-00-00 00:00:00'),
(7, 'Mihael', 'TuÅ¡ek', 'mtusek', 'mtus', 'Pavlinska 7', 'VaraÅ¾din', 'mtus@foi.hr', '099 851 6971', 3, 1, 0, '0000-00-00 00:00:00'),
(8, 'Jurica', 'PotoÄnjak', 'jpotoc', 'jpot', 'Pavlinska 8', 'ÄŒakovec', 'jpot@foi.hr', '098 948 341', 3, 1, 0, '0000-00-00 00:00:00'),
(9, 'Mislav', 'Sraka', 'msraka', 'msrak', 'Pavlinska 9', 'Prelog', 'msrak@foi.hr', '092 616 5555', 3, 1, 0, '0000-00-00 00:00:00'),
(10, 'Viktor', 'Lazar', 'vlazar', 'vlaz', 'Pavlinska 10', 'ÄŒakovec', 'vlaz@foi.hr', '099 999 999', 2, 1, 0, '0000-00-00 00:00:00'),
(30, 'Zdravko', 'DominiÄ‡', 'zdomin', 'lozinka', 'Palovska 10', 'Koprivnica', 'zdomin@gmail.com', '0987895432', 3, 1, 0, '0000-00-00 00:00:00'),
(32, 'Damir', 'Å½vorc', 'dzvorc', 'lozink', 'ZAVNOH-a', 'ÄŒakovec', 'dzvorc@gmail.com', '098473589', 3, 0, 0, '0000-00-00 00:00:00'),
(33, 'Kristina', 'TrupkoviÄ‡', 'kristina', 'lozinka', 'ZAVNOH-a', 'ÄŒakovec', 'ktrup@gmail.com', '098 9988 11 22', 2, 0, 0, '2014-06-22 14:33:36');

-- --------------------------------------------------------

--
-- Table structure for table `marka`
--

CREATE TABLE IF NOT EXISTS `marka` (
  `idmarke` int(11) NOT NULL auto_increment,
  `naziv` varchar(45) NOT NULL,
  PRIMARY KEY  (`idmarke`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=90 ;

--
-- Dumping data for table `marka`
--

INSERT INTO `marka` (`idmarke`, `naziv`) VALUES
(1, 'Abarth'),
(2, 'Alfa Romeo'),
(3, 'Asia Motors'),
(4, 'Aston Martin'),
(5, 'Audi'),
(6, 'Austin'),
(7, 'Autobianchi'),
(8, 'Bentley'),
(9, 'BMW'),
(10, 'Bugatti'),
(11, 'Buick'),
(12, 'Cadillac'),
(13, 'Carver'),
(14, 'Chevrolet'),
(15, 'Chrysler'),
(16, 'Citroen'),
(17, 'Corvette'),
(18, 'Dacia'),
(19, 'Daewoo'),
(20, 'Daihatsu'),
(21, 'Daimler'),
(22, 'Datsun'),
(23, 'Dodge'),
(24, 'Donkervoort'),
(25, 'Ferrari'),
(26, 'Fiat'),
(27, 'Fisker'),
(28, 'Ford'),
(29, 'FSO'),
(30, 'Galloper'),
(31, 'Honda'),
(32, 'Hummer'),
(33, 'Hyundai'),
(34, 'Infiniti'),
(35, 'Innocenti'),
(36, 'Iveco'),
(37, 'Jaguar'),
(38, 'Jeep'),
(39, 'Josse'),
(40, 'Kia'),
(41, 'KTM'),
(42, 'Lada'),
(43, 'Lamborghini'),
(44, 'Lancia'),
(45, 'Land Rover'),
(46, 'Landwind'),
(47, 'Lexus'),
(48, 'Lincoln'),
(49, 'Lotus'),
(50, 'Marcos'),
(51, 'Maserati'),
(52, 'Maybach'),
(53, 'Mazda'),
(54, 'Mega'),
(55, 'Mercedes'),
(56, 'Mercury'),
(57, 'MG'),
(58, 'Mini'),
(59, 'Mitsubishi'),
(60, 'Morgan'),
(61, 'Morris'),
(62, 'Nissan'),
(63, 'Noble'),
(64, 'Opel'),
(65, 'Peugeot'),
(66, 'PGO'),
(67, 'Pontiac'),
(68, 'Porsche'),
(69, 'Princess'),
(70, 'Renault'),
(71, 'Rolls-Royce'),
(72, 'Rover'),
(73, 'Saab'),
(74, 'Seat'),
(75, 'Skoda'),
(76, 'Smart'),
(77, 'Spectre'),
(78, 'SsangYong'),
(79, 'Subaru'),
(80, 'Suzuki'),
(81, 'Talbot'),
(82, 'Tesla'),
(83, 'Think'),
(84, 'Toyota'),
(85, 'Triumph'),
(86, 'TVR'),
(87, 'Volkswagen'),
(88, 'Volvo'),
(89, 'Yugo');

-- --------------------------------------------------------

--
-- Table structure for table `parking`
--

CREATE TABLE IF NOT EXISTS `parking` (
  `idparkinga` int(11) NOT NULL auto_increment,
  `naziv` varchar(45) character set latin1 NOT NULL,
  `brmjesta` int(11) NOT NULL,
  `sat` float NOT NULL,
  `dnevna` float NOT NULL,
  `mjesecna` float NOT NULL,
  `naplata` varchar(10) collate utf8_slovenian_ci NOT NULL,
  PRIMARY KEY  (`idparkinga`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=13 ;

--
-- Dumping data for table `parking`
--

INSERT INTO `parking` (`idparkinga`, `naziv`, `brmjesta`, `sat`, `dnevna`, `mjesecna`, `naplata`) VALUES
(1, 'ÄŒakovec', 65, 3, 20, 300, '8-20'),
(2, 'VaraÅ¾din', 75, 3, 25, 350, '7-20'),
(3, 'Zagreb Sjever', 100, 4, 40, 400, '7-21'),
(4, 'Zagreb SrediÅ¡te', 200, 5, 50, 500, '7-22'),
(5, 'Zagreb Jug', 120, 4, 40, 400, '8-20');

-- --------------------------------------------------------

--
-- Table structure for table `pomak`
--

CREATE TABLE IF NOT EXISTS `pomak` (
  `pomak` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `pomak`
--

INSERT INTO `pomak` (`pomak`) VALUES
(120);

-- --------------------------------------------------------

--
-- Table structure for table `prijava`
--

CREATE TABLE IF NOT EXISTS `prijava` (
  `idprijave` int(11) NOT NULL auto_increment,
  `korisnik` int(11) NOT NULL,
  `aktivnost` int(11) NOT NULL,
  `vrijeme` datetime default NULL,
  PRIMARY KEY  (`idprijave`),
  KEY `fk_prijava_korisnik1_idx` (`korisnik`),
  KEY `fk_prijava_aktivnost1_idx` (`aktivnost`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=100 ;

--
-- Dumping data for table `prijava`
--

INSERT INTO `prijava` (`idprijave`, `korisnik`, `aktivnost`, `vrijeme`) VALUES
(80, 1, 4, '2014-06-23 17:18:53'),
(81, 9, 1, '2014-06-23 17:22:40'),
(82, 9, 6, '2014-06-23 17:22:54'),
(83, 1, 6, '2014-06-23 17:30:16'),
(84, 1, 1, '2014-06-23 18:04:26'),
(85, 1, 6, '2014-06-23 18:37:57'),
(86, 1, 2, '2014-06-23 19:44:10'),
(87, 1, 1, '2014-06-23 19:44:14'),
(88, 1, 1, '2014-06-23 22:59:06'),
(89, 1, 6, '2014-06-24 00:39:53'),
(90, 1, 1, '1970-01-01 01:00:00'),
(91, 1, 6, '1970-01-01 01:00:00'),
(92, 1, 1, '1970-01-01 01:00:00'),
(93, 1, 6, '1970-01-01 01:00:00'),
(94, 1, 1, '1970-01-01 01:00:00'),
(95, 1, 6, '2014-06-24 01:35:48'),
(96, 1, 1, '2014-06-24 01:35:54'),
(97, 1, 3, '2014-06-29 02:15:55'),
(98, 1, 6, '2014-06-29 02:21:20'),
(99, 1, 1, '2014-06-29 10:25:10');

-- --------------------------------------------------------

--
-- Table structure for table `pripada`
--

CREATE TABLE IF NOT EXISTS `pripada` (
  `parking` int(11) NOT NULL,
  `zaposlenik` int(11) NOT NULL,
  `datumzaposljavanja` date default NULL,
  PRIMARY KEY  (`parking`,`zaposlenik`),
  KEY `fk_parking_has_korisnik_korisnik1_idx` (`zaposlenik`),
  KEY `fk_parking_has_korisnik_parking_idx` (`parking`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pripada`
--

INSERT INTO `pripada` (`parking`, `zaposlenik`, `datumzaposljavanja`) VALUES
(1, 4, '2014-06-18'),
(1, 5, NULL),
(2, 6, NULL),
(3, 3, '2014-06-10'),
(4, 2, '2014-06-21'),
(4, 6, '2014-06-11'),
(5, 5, NULL),
(5, 10, '2014-06-22');

-- --------------------------------------------------------

--
-- Table structure for table `slike`
--

CREATE TABLE IF NOT EXISTS `slike` (
  `idslike` int(11) NOT NULL auto_increment,
  `slika` blob NOT NULL,
  `kazna` int(11) NOT NULL,
  PRIMARY KEY  (`idslike`),
  KEY `fk_slike_kazna1_idx` (`kazna`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `slike`
--


-- --------------------------------------------------------

--
-- Table structure for table `tip_korisnika`
--

CREATE TABLE IF NOT EXISTS `tip_korisnika` (
  `idtipa` int(11) NOT NULL auto_increment,
  `naziv` varchar(40) NOT NULL,
  `prioritet` int(11) default NULL,
  PRIMARY KEY  (`idtipa`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tip_korisnika`
--

INSERT INTO `tip_korisnika` (`idtipa`, `naziv`, `prioritet`) VALUES
(1, 'Administrator', 1),
(2, 'Zaposlenik', 2),
(3, 'VozaÄ', 3);

-- --------------------------------------------------------

--
-- Table structure for table `vozilo`
--

CREATE TABLE IF NOT EXISTS `vozilo` (
  `idvozila` int(11) NOT NULL auto_increment,
  `registracija` varchar(15) character set utf8 collate utf8_slovenian_ci NOT NULL,
  `vlasnik` int(11) NOT NULL,
  `marka` int(11) NOT NULL,
  PRIMARY KEY  (`idvozila`),
  KEY `fk_vozilo_korisnik1_idx` (`vlasnik`),
  KEY `fk_vozilo_marka1_idx` (`marka`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `vozilo`
--

INSERT INTO `vozilo` (`idvozila`, `registracija`, `vlasnik`, `marka`) VALUES
(2, 'ÄŒK-1234-HR', 1, 5),
(3, 'KC-1234-HR', 2, 10),
(4, 'KA-1331-HR', 3, 15),
(5, 'VÅ½-1894-HR', 4, 25),
(6, 'ZG-5374-HR', 5, 35),
(7, 'PU-5234-HR', 6, 45),
(8, 'ST-9034-HR', 7, 50),
(9, 'ÄŒK-9876-HR', 8, 55),
(10, 'OS-1734-HR', 9, 65),
(11, 'ÄŒK-1934-HR', 10, 75),
(12, 'ÄŒK-254-AB', 30, 12),
(13, 'ZG-5634-CR', 32, 4),
(14, 'ÄŒK-8888-Hr', 33, 58);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `karta`
--
ALTER TABLE `karta`
  ADD CONSTRAINT `fk_karta_parking1` FOREIGN KEY (`parking`) REFERENCES `parking` (`idparkinga`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_karta_vozilo1` FOREIGN KEY (`vozilo`) REFERENCES `vozilo` (`idvozila`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `kazna`
--
ALTER TABLE `kazna`
  ADD CONSTRAINT `fk_kazna_parking1` FOREIGN KEY (`parking`) REFERENCES `parking` (`idparkinga`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_kazna_vozilo1` FOREIGN KEY (`vozilo`) REFERENCES `vozilo` (`idvozila`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `kazna_ibfk_1` FOREIGN KEY (`izdao`) REFERENCES `korisnik` (`idkorisnika`);

--
-- Constraints for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD CONSTRAINT `fk_korisnik_tip_korisnika1` FOREIGN KEY (`tip`) REFERENCES `tip_korisnika` (`idtipa`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `prijava`
--
ALTER TABLE `prijava`
  ADD CONSTRAINT `fk_prijava_korisnik1` FOREIGN KEY (`korisnik`) REFERENCES `korisnik` (`idkorisnika`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `pripada`
--
ALTER TABLE `pripada`
  ADD CONSTRAINT `fk_parking_has_korisnik_korisnik1` FOREIGN KEY (`zaposlenik`) REFERENCES `korisnik` (`idkorisnika`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_parking_has_korisnik_parking` FOREIGN KEY (`parking`) REFERENCES `parking` (`idparkinga`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `slike`
--
ALTER TABLE `slike`
  ADD CONSTRAINT `fk_slike_kazna1` FOREIGN KEY (`kazna`) REFERENCES `kazna` (`idkazne`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `vozilo`
--
ALTER TABLE `vozilo`
  ADD CONSTRAINT `fk_vozilo_korisnik1` FOREIGN KEY (`vlasnik`) REFERENCES `korisnik` (`idkorisnika`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_vozilo_marka1` FOREIGN KEY (`marka`) REFERENCES `marka` (`idmarke`) ON DELETE NO ACTION ON UPDATE NO ACTION;
