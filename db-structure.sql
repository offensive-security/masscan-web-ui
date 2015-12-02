DROP TABLE IF EXISTS `hosts`;
CREATE TABLE IF NOT EXISTS `hosts` (
`host_id` bigint(10) unsigned NOT NULL,
  `ip` char(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `added_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


DROP TABLE IF EXISTS `ports`;
CREATE TABLE IF NOT EXISTS `ports` (
`id` bigint(20) unsigned NOT NULL,
  `ip` bigint(20) unsigned NOT NULL DEFAULT '0',
  `port_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `scanned_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `protocol` enum('tcp','utp') NOT NULL,
  `state` varchar(10) NOT NULL DEFAULT '',
  `reason` varchar(255) NOT NULL DEFAULT '',
  `reason_ttl` int(10) unsigned NOT NULL DEFAULT '0',
  `service` varchar(100) NOT NULL DEFAULT '',
  `banner` text NOT NULL,
  `title` text NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


ALTER TABLE `hosts` ADD PRIMARY KEY (`host_id`), ADD UNIQUE KEY `ip` (`ip`);
ALTER TABLE `ports` ADD PRIMARY KEY (`id`), ADD KEY `ip` (`ip`);
ALTER TABLE `ports` ADD FULLTEXT( `banner`, `title`);
ALTER TABLE `ports` ADD INDEX(`scanned_ts`);

ALTER TABLE `hosts` MODIFY `host_id` bigint(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
ALTER TABLE `ports` MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
