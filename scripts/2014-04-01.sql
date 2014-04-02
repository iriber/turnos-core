CREATE TABLE IF NOT EXISTS `trn_cliente_obra_social` (
  `oid` bigint(20) NOT NULL AUTO_INCREMENT,
  `cliente_oid` bigint(20) NOT NULL,
  `obraSocial_oid` int(11) NOT NULL,
  `nroObraSocial` varchar(100) NOT NULL,
  `afiliadoVoluntario` tinyint(1) NOT NULL,
  PRIMARY KEY (`oid`),
  KEY `cliente_oid` (`cliente_oid`),
  KEY `obraSocial_oid` (`obraSocial_oid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


ALTER TABLE `trn_cliente` ADD `clienteObraSocial_oid` BIGINT NOT NULL ;

ALTER TABLE `trn_cliente` CHANGE `clienteObraSocial_oid` `clienteObraSocial_oid` BIGINT( 20 ) NULL ;

ALTER TABLE `trn_turno` ADD `clienteObraSocial_oid` BIGINT  NULL ;

ALTER TABLE `trn_turno` CHANGE `clienteObraSocial_oid` `clienteObraSocial_oid` BIGINT( 20 ) NULL ;

ALTER TABLE `trn_practica` ADD `clienteObraSocial_oid` BIGINT  NULL ;

ALTER TABLE `trn_practica` CHANGE `clienteObraSocial_oid` `clienteObraSocial_oid` BIGINT( 20 ) NULL ;
