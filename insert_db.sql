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
  `km_tanka` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`km_id`),
  UNIQUE KEY `km_mei` (`km_mei`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `kamoku` (`km_id`, `km_mei`, `tani`, `km_tanka`) VALUES
(1,	'内税',	'%',	10.00),
(2,	'源泉徴収差引',	'%',	10.21),
(3,	'消費税',	'%',	10.00),
(100,	'サーバー保守',	NULL,	NULL),
(101,	'サイト修正',	NULL,	NULL),
(102,	'WEBサイト構築',	NULL,	NULL);

DROP TABLE IF EXISTS `seikyu`;
CREATE TABLE `seikyu` (
  `sk_id` int(11) NOT NULL AUTO_INCREMENT,
  `tk_id` int(11) NOT NULL,
  `ow_id` int(11) NOT NULL,
  `seikyubi` date NOT NULL,
  `kaishu` tinyint(1) DEFAULT NULL,
  `kaishubi` date DEFAULT NULL,
  PRIMARY KEY (`sk_id`),
  KEY `tk_id` (`tk_id`),
  KEY `ow_id` (`ow_id`),
  CONSTRAINT `seikyu_ibfk_1` FOREIGN KEY (`tk_id`) REFERENCES `tokuisaki` (`tk_id`),
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

INSERT INTO `seikyusha` (`ow_id`, `ow_mei`, `ow_zip`, `ow_jusho`, `ginko`) VALUES
(1,	'スズキイチロウ',	'101-0029',	'東京都千代田区神田相生町2',	'じぶん銀行\\n(普通)1234545\\n口座名義：スズキイチロウ'),
(2,	'スズキイチロウ',	'101-0029',	'東京都千代田区神田相生町2',	'振込先：あの銀行本店(支店番号:400)\\n（普通）0336459 \\n口座名義：ジブン');

DROP TABLE IF EXISTS `tokuisaki`;
CREATE TABLE `tokuisaki` (
  `tk_id` int(11) NOT NULL AUTO_INCREMENT,
  `tk_mei` varchar(100) NOT NULL,
  `tk_zip` varchar(8) DEFAULT NULL,
  `tk_jusho` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`tk_id`),
  KEY `tk_mei` (`tk_mei`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `tokuisaki` (`tk_id`, `tk_mei`, `tk_zip`, `tk_jusho`) VALUES
(1,	'田中電機工事',	NULL,	'埼玉市豊岩石田坂字九十田９'),
(2,	'株式会社トップモーション',	NULL,	'世田谷区等々力1-11'),
(3,	'東京健康スポーツ大学',	NULL,	'新宿区高田馬場3-9'),
(4,	'株式会社ハウステック',	NULL,	'仙台市泉区上谷刈１丁目５'),
(5,	'富士産業株式会社',	NULL,	'高崎市旭北栄町１－４'),
(6,	'N文房具店',	NULL,	'東京都千代田区神田');

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


-- 2020-12-05 10:32:11
