CREATE TABLE IF NOT EXISTS `#__wm_filehashes` (
  `id_filehash` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pathhash` varchar(40) CHARACTER SET utf8 NOT NULL,
  `filehash` varchar(40) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id_filehash`),
  UNIQUE KEY `pathhash` (`pathhash`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__wm_filestack` (
  `filestack_id` int(10) unsigned NOT NULL,
  `path` varchar(300) NOT NULL,
  PRIMARY KEY (`filestack_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__wm_kvs` (
  `id_kv` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wm_key` varchar(100) NOT NULL,
  `wm_value` text NOT NULL,
  PRIMARY KEY (`id_kv`),
  UNIQUE KEY `wm_key` (`wm_key`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__wm_reportitems` (
  `id_reportitem` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `reportitem` text NOT NULL,
  `audit_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id_reportitem`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;