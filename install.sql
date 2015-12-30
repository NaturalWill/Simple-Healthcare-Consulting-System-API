create table IF NOT EXISTS `users` (
  `uid` mediumint(8) unsigned NOT NULL auto_increment,
  username char(15) NOT NULL default '',
  usertype bit NOT NULL default 0,
  `password` char(32) NOT NULL default '',
  PRIMARY KEY  (`uid`),
  UNIQUE (username) 
)DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `zixun` (
  `zid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `subject` char(80) NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `message` mediumtext NOT NULL,
  PRIMARY KEY (`zid`)
)DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `comment` (
  `cid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `zid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `message` mediumtext NOT NULL,
  PRIMARY KEY (`cid`)
)DEFAULT CHARSET=utf8;
