DROP TABLE IF EXISTS `#__wm_dirstack`;
CREATE TABLE IF NOT EXISTS `#__wm_dirstack` (
  `path` varchar(300) NOT NULL,
  `mode` varchar(1) NOT NULL DEFAULT 'w',
  KEY `mode` (`mode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__wm_filehashes`;
CREATE TABLE IF NOT EXISTS `#__wm_filehashes` (
  `pathhash` varchar(40) NOT NULL,
  `filehash` varchar(40) NOT NULL,
  `mode` varchar(1) NOT NULL DEFAULT 'w',
  UNIQUE KEY `pathhash` (`pathhash`,`mode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__wm_filestack`;
CREATE TABLE IF NOT EXISTS `#__wm_filestack` (
  `path` varchar(300) NOT NULL,
  `mode` varchar(1) NOT NULL DEFAULT 'w',
  KEY `mode` (`mode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__wm_kvs`;
CREATE TABLE IF NOT EXISTS `#__wm_kvs` (
  `id_kv` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wm_key` varchar(100) NOT NULL,
  `wm_value` text NOT NULL,
  `mode` varchar(1) NOT NULL DEFAULT 'w',
  PRIMARY KEY (`id_kv`),
  UNIQUE KEY `wm_key` (`wm_key`,`mode`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__wm_reportitems`;
CREATE TABLE IF NOT EXISTS `#__wm_reportitems` (
  `id_reportitem` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `reportitem` text NOT NULL,
  `audit_name` varchar(100) NOT NULL,
  `mode` varchar(1) NOT NULL DEFAULT 'w',
  PRIMARY KEY (`id_reportitem`),
  KEY `mode` (`mode`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;