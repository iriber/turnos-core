ALTER TABLE `security_user` ADD `lastLogin` DATETIME NOT NULL ;

ALTER TABLE `security_user` ADD `loginFrom` VARCHAR( 50 ) NOT NULL ;

ALTER TABLE `security_user` ADD `logged` TINYINT NOT NULL ;

