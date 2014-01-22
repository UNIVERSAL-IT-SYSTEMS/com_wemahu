CREATE TABLE IF NOT EXISTS `#__wm_dirstack` (
  `path` varchar(300) NOT NULL,
  `mode` varchar(1) NOT NULL DEFAULT 'w',
  KEY `mode` (`mode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__wm_filehashes` (
  `pathhash` varchar(40) NOT NULL,
  `filehash` varchar(40) NOT NULL,
  `mode` varchar(1) NOT NULL DEFAULT 'w',
  UNIQUE KEY `pathhash` (`pathhash`,`mode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__wm_filestack` (
  `path` varchar(300) NOT NULL,
  `mode` varchar(1) NOT NULL DEFAULT 'w',
  KEY `mode` (`mode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__wm_kvs` (
  `id_kv` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wm_key` varchar(100) NOT NULL,
  `wm_value` text NOT NULL,
  `mode` varchar(1) NOT NULL DEFAULT 'w',
  PRIMARY KEY (`id_kv`),
  UNIQUE KEY `wm_key` (`wm_key`,`mode`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__wm_reportitems` (
  `id_reportitem` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `reportitem` text NOT NULL,
  `audit_name` varchar(100) NOT NULL,
  `mode` varchar(1) NOT NULL DEFAULT 'w',
  PRIMARY KEY (`id_reportitem`),
  KEY `mode` (`mode`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__wm_rulesets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `filecheck` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `scandir` varchar(250) NOT NULL,
  `regex_check` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `regex_db` varchar(50) NOT NULL,
  `hash_check` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `filetypes` varchar(250) NOT NULL,
  `filesize_max` bigint(20) unsigned NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `#__wm_rulesets` (`id`, `name`, `filecheck`, `scandir`, `regex_check`, `regex_db`, `hash_check`, `filetypes`, `filesize_max`, `created`) VALUES
(1, 'default', 1, '', 1, 'regex_complete', 1, 'php,php4,php5,jpg,png,gif,js,html,htm,xml,htaccess', 500000, '2013-05-01 07:45:42');