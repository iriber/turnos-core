CREATE TABLE IF NOT EXISTS `trn_plan_obra_social` (
  `oid` bigint(20) NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8 NOT NULL,
  `obraSocial_oid` bigint(20) NOT NULL,
  PRIMARY KEY (`oid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `trn_plan_obra_social` CHANGE `oid` `oid` BIGINT( 20 ) NOT NULL AUTO_INCREMENT ;

ALTER TABLE `trn_cliente_obra_social` ADD `planObraSocial_oid` BIGINT NULL ,
ADD INDEX ( `planObraSocial_oid` ) ;

