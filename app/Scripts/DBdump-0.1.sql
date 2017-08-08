-- Only import this file if you have already imported the previous DBdump file before 8/8/17 - Create syntax for TABLE 'bowhead_ohlc_tick'
CREATE TABLE `bowhead_ohlc_tick` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `instrument` varchar(10) DEFAULT NULL,
  `ctime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `timeid` bigint(28) DEFAULT NULL,
  `open` float DEFAULT NULL,
  `high` float DEFAULT NULL,
  `low` float DEFAULT NULL,
  `close` float DEFAULT NULL,
  `volume` int(18) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `instrument` (`instrument`,`timeid`),
  KEY `ctime` (`ctime`)
) ENGINE=InnoDB AUTO_INCREMENT=78080 DEFAULT CHARSET=utf8;