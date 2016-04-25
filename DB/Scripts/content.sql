-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Lun 25 Avril 2016 à 09:32
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `golden_ticket`
--

-- --------------------------------------------------------

--
-- Structure de la table `commentary`
--

CREATE TABLE IF NOT EXISTS `commentary` (
  `num_commentary` int(11) NOT NULL AUTO_INCREMENT,
  `rate_commentary` int(11) DEFAULT NULL,
  `text_commentary` varchar(400) COLLATE utf8_unicode_ci DEFAULT NULL,
  `num_event` int(11) DEFAULT NULL,
  `num_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`num_commentary`),
  KEY `IX_Relationship29` (`num_event`),
  KEY `IX_Relationship33` (`num_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `num_event` int(11) NOT NULL AUTO_INCREMENT,
  `name_event` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `minimalPrice_event` int(11) DEFAULT NULL,
  `startDate_event` date DEFAULT NULL,
  `startHour_event` time DEFAULT NULL,
  `endDate_event` date DEFAULT NULL,
  `endHour_event` time DEFAULT NULL,
  `desc_event` text COLLATE utf8_unicode_ci,
  `num_status` int(11) DEFAULT NULL,
  `num_ET` int(11) DEFAULT NULL,
  `coverImage_event` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`num_event`),
  KEY `IX_Relationship22` (`num_status`),
  KEY `IX_Relationship23` (`num_ET`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Contenu de la table `event`
--

INSERT INTO `event` (`num_event`, `name_event`, `minimalPrice_event`, `startDate_event`, `startHour_event`, `endDate_event`, `endHour_event`, `desc_event`, `num_status`, `num_ET`, `coverImage_event`) VALUES
(6, 'Beyoncé - The Formation World Tour - MIAMI', 45, '2016-04-27', '19:30:00', '2016-04-28', '00:16:00', 'Infos\r\nThe Formation World Tour is the upcoming seventh concert tour by American singer Beyoncé in support of her sixth studio album, Lemonade. The all-stadium tour was announced following her guest appearance at the Super Bowl 50 halftime show. The tour is currently scheduled to start in Miami, Florida and conclude in Barcelona, Spain. The tour''s title is in reference to Beyoncé''s 2016 song "Formation."\r\n\r\nParking\r\nThere are 4 parking garages on site. $30.00 charge. To purchase parking, go to Marlins.com. \r\n\r\nGeneral Rules\r\nITEMS -NOT- ALLOWED IN FACILITY : GLASS BOTTLES, METAL CANS, HARD-SIDED COOLERS, OPEN OR HARD-SIDED CONTAINERS, COMMERCIAL-GRADE AUDIO, VIDEO OR PHOTOGRAPHIC EQUIPMENT, ALCOHOL OR ILLEGAL SUBSTANCES, SOFT DRINKS OR SPORTS/ENERGY DRINKS, FIREWORKS, LASER POINTERS, BROOMS, POLES, GOLF UMBRELLAS OR STROLLERS, WEAPONS (REGARDLESS OF PERMIT), PETS (EXCEPT FOR SERVICE ANIMALS OR DURING SPECIFIC PROMOTIONS. \r\n\r\n* ITEMS ALLOWED IN FACILITY : ONE SOFT-SIDED, FACTORY-SEALED WATER BOTTLE OF 20 OUNCES OR LESS, ONE SINGLE SERVING FOOD ITEM CONTAINED IN A CLEAR PLASTIC BAG - PIECES OF FRUIT MUST BE SLICED, BAGS NO LARGER THAN 16"X16"X8" IN SIZE - ALL BAGS ARE SUBJECT TO INSPECTION.\r\n\r\n* SMOKING POLICY : SMOKING IS NOT PERMITTED.', NULL, 6, '5539d94c3f2e9b66a8fbcb6a9b5f0f0b.jpg'),
(7, 'Kevin Hart: WHAT NOW TOUR - NEW YORK', 45, '2016-06-15', '19:00:00', '2016-06-15', '23:00:00', 'On July 16, 2015, Universal Pictures announced that Kevin Hart: What Now, a stand-up comedy film starring Kevin Hart, will be released theatrically in the United States on October 14, 2016. The concert was filmed live on August 30, 2015 in front of 53,000 people at Philadelphia’s Lincoln Financial Field, with a live dress rehearsal for a small, intimate audience filmed at the stadium the night before on August 29, 2015.\r\n\r\nThe film''s teaser trailer was released January 12, 2016 and was shown in front of screenings of Universal''s Ride Along 2.', NULL, 7, 'e641795aff833d4c69c6382e76108a0e.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `eventtype`
--

CREATE TABLE IF NOT EXISTS `eventtype` (
  `num_ET` int(11) NOT NULL AUTO_INCREMENT,
  `name_ET` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`num_ET`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Contenu de la table `eventtype`
--

INSERT INTO `eventtype` (`num_ET`, `name_ET`) VALUES
(4, 'Sport'),
(6, 'Music'),
(7, 'Comedy');

-- --------------------------------------------------------

--
-- Structure de la table `order_gd`
--

CREATE TABLE IF NOT EXISTS `order_gd` (
  `num_order` int(11) NOT NULL AUTO_INCREMENT,
  `num_user` int(11) DEFAULT NULL,
  `status_order` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`num_order`),
  KEY `IX_Relationship20` (`num_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Contenu de la table `order_gd`
--

INSERT INTO `order_gd` (`num_order`, `num_user`, `status_order`) VALUES
(4, 7, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `placecategory`
--

CREATE TABLE IF NOT EXISTS `placecategory` (
  `num_PC` int(11) NOT NULL AUTO_INCREMENT,
  `nom_PC` int(11) DEFAULT NULL,
  `price_PC` int(11) DEFAULT NULL,
  `initialNumberOfTicket_PC` int(11) DEFAULT NULL,
  `actualNumberOfTickets_PC` int(11) DEFAULT NULL,
  `num_event` int(11) DEFAULT NULL,
  PRIMARY KEY (`num_PC`),
  KEY `IX_Relationship3` (`num_event`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `num_status` int(11) NOT NULL AUTO_INCREMENT,
  `name_status` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`num_status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Contenu de la table `status`
--

INSERT INTO `status` (`num_status`, `name_status`) VALUES
(1, 'Sold-out'),
(2, 'Not open yet'),
(3, 'Available');

-- --------------------------------------------------------

--
-- Structure de la table `ticket`
--

CREATE TABLE IF NOT EXISTS `ticket` (
  `num_ticket` int(11) NOT NULL AUTO_INCREMENT,
  `num_event` int(11) DEFAULT NULL,
  `numPlace_ticket` int(11) DEFAULT NULL,
  PRIMARY KEY (`num_ticket`),
  KEY `IX_Relationship37` (`num_event`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ticketsbyorder`
--

CREATE TABLE IF NOT EXISTS `ticketsbyorder` (
  `num_ticket` int(11) NOT NULL,
  `num_order` int(11) NOT NULL,
  PRIMARY KEY (`num_ticket`,`num_order`),
  KEY `Relationship19` (`num_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `num_user` int(11) NOT NULL AUTO_INCREMENT,
  `name_user` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `surname_user` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `login_user` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `password_user` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `salt_user` varchar(23) COLLATE utf8_unicode_ci NOT NULL,
  `role_user` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`num_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`num_user`, `name_user`, `surname_user`, `login_user`, `password_user`, `salt_user`, `role_user`) VALUES
(7, 'admin', 'admin', 'admin', 'YoKhvUWiBBZF+OQ79cmOW6N99fh3JUp51YL1vMKdcLoThwpxjyoEM2Ao1ftxJR7TLV3+r1NeR62h6W3T1GU6AA==', 'd5c0a7a0e0c6efc7e493399', 'ROLE_ADMIN');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `commentary`
--
ALTER TABLE `commentary`
  ADD CONSTRAINT `Relationship33` FOREIGN KEY (`num_user`) REFERENCES `user` (`num_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Relationship29` FOREIGN KEY (`num_event`) REFERENCES `event` (`num_event`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `Relationship23` FOREIGN KEY (`num_ET`) REFERENCES `eventtype` (`num_ET`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Relationship22` FOREIGN KEY (`num_status`) REFERENCES `status` (`num_status`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `order_gd`
--
ALTER TABLE `order_gd`
  ADD CONSTRAINT `Relationship20` FOREIGN KEY (`num_user`) REFERENCES `user` (`num_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `placecategory`
--
ALTER TABLE `placecategory`
  ADD CONSTRAINT `Relationship3` FOREIGN KEY (`num_event`) REFERENCES `event` (`num_event`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `Relationship37` FOREIGN KEY (`num_event`) REFERENCES `event` (`num_event`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ticketsbyorder`
--
ALTER TABLE `ticketsbyorder`
  ADD CONSTRAINT `Relationship19` FOREIGN KEY (`num_order`) REFERENCES `order_gd` (`num_order`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Relationship18` FOREIGN KEY (`num_ticket`) REFERENCES `ticket` (`num_ticket`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
