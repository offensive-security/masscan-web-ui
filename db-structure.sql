DROP TABLE IF EXISTS `data`;
CREATE TABLE IF NOT EXISTS `data` (
`id` bigint(20) unsigned NOT NULL,
  `ip` int(10) unsigned NOT NULL DEFAULT '0',
  `port_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `scanned_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `protocol` enum('tcp','utp') NOT NULL,
  `state` varchar(10) NOT NULL DEFAULT '',
  `reason` varchar(255) NOT NULL DEFAULT '',
  `reason_ttl` int(10) unsigned NOT NULL DEFAULT '0',
  `service` varchar(100) NOT NULL DEFAULT '',
  `banner` text NOT NULL,
  `title` text NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
ALTER TABLE `data` ADD PRIMARY KEY (`id`), ADD KEY `scanned_ts` (`scanned_ts`), ADD KEY `ip` (`ip`), ADD FULLTEXT KEY `banner` (`banner`,`title`);
ALTER TABLE `data` MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
