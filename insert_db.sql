-- Adminer 4.7.6 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `kamoku`;
CREATE TABLE `kamoku` (
  `km_id` int(11) NOT NULL AUTO_INCREMENT,
  `km_mei` varchar(100) NOT NULL,
  `tani` varchar(10) DEFAULT NULL,
  `km_tanka` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`km_id`),
  UNIQUE KEY `km_mei` (`km_mei`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `seikyu`;
CREATE TABLE `seikyu` (
  `sk_id` int(11) NOT NULL AUTO_INCREMENT,
  `tk_id` int(11) NOT NULL,
  `tax_id` int(11) NOT NULL,
  `ow_id` int(11) NOT NULL,
  `seikyubi` date NOT NULL,
  `kaishu` tinyint(1) DEFAULT NULL,
  `kaishubi` date DEFAULT NULL,
  PRIMARY KEY (`sk_id`),
  KEY `tk_id` (`tk_id`),
  KEY `tax_id` (`tax_id`),
  KEY `ow_id` (`ow_id`),
  CONSTRAINT `seikyu_ibfk_1` FOREIGN KEY (`tk_id`) REFERENCES `tokuisaki` (`tk_id`),
  CONSTRAINT `seikyu_ibfk_2` FOREIGN KEY (`tax_id`) REFERENCES `tax` (`tax_id`),
  CONSTRAINT `seikyu_ibfk_3` FOREIGN KEY (`ow_id`) REFERENCES `seikyusha` (`ow_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `seikyusha`;
CREATE TABLE `seikyusha` (
  `ow_id` int(11) NOT NULL AUTO_INCREMENT,
  `ow_mei` varchar(100) NOT NULL,
  `ow_zip` varchar(8) DEFAULT NULL,
  `ow_jusho` varchar(100) DEFAULT NULL,
  `ginko` varchar(100) NOT NULL,
  PRIMARY KEY (`ow_id`),
  KEY `ow_mei` (`ow_mei`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `tax`;
CREATE TABLE `tax` (
  `tax_id` int(11) NOT NULL AUTO_INCREMENT,
  `tax_mei` varchar(100) NOT NULL,
  `tax_rc` float NOT NULL,
  `tani` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`tax_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `tokuisaki`;
CREATE TABLE `tokuisaki` (
  `tk_id` int(11) NOT NULL AUTO_INCREMENT,
  `tk_mei` varchar(100) NOT NULL,
  `tk_zip` varchar(8) DEFAULT NULL,
  `tk_jusho` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`tk_id`),
  KEY `tk_mei` (`tk_mei`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `uchiwake`;
CREATE TABLE `uchiwake` (
  `sk_id` int(11) NOT NULL AUTO_INCREMENT,
  `km_id` int(11) NOT NULL,
  `suryo` int(11) NOT NULL,
  `tani` varchar(10) DEFAULT NULL,
  `tanka` decimal(10,0) NOT NULL,
  `biko` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`sk_id`,`km_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `uchiwake` (`sk_id`, `km_id`, `suryo`, `tani`, `tanka`, `biko`) VALUES
(1,	3,	1,	'',	12340,	''),
(2,	3,	1,	'',	12340,	'備考1'),
(4,	2,	1,	'',	12000,	''),
(4,	3,	1,	'',	32230,	'備考11'),
(5,	3,	1,	'',	302728,	''),
(6,	3,	1,	'',	302728,	''),
(7,	2,	1,	'',	11219,	''),
(7,	3,	1,	'',	293037,	''),
(8,	2,	1,	'',	31406,	''),
(8,	3,	1,	'',	1119,	''),
(9,	2,	1,	'',	1010,	''),
(9,	3,	1,	'',	910,	'');

-- 2020-12-05 10:14:58
