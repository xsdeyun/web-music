DROP TABLE IF EXISTS `ocink_links`;
CREATE TABLE `ocink_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT '网站标题',
  `url` text COMMENT '网站链接',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ocink_order`;
CREATE TABLE IF NOT EXISTS `ocink_order` (
  `trade_no` varchar(64) NOT NULL,
  `type` varchar(20) DEFAULT NULL,
  `orderid` varchar(64) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `name` varchar(64) DEFAULT NULL,
  `money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`trade_no`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `ocink_pays`;
CREATE TABLE IF NOT EXISTS `ocink_pays` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `qq` char(20) DEFAULT NULL,
  `orderid` char(64) DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  `endtime` datetime DEFAULT NULL,
  `name` char(64) DEFAULT NULL,
  `money` decimal(6,2) NOT NULL DEFAULT '0.00',
  `type` varchar(10) DEFAULT NULL,
  `shop` varchar(225) DEFAULT NULL,
  `shopid` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;