CREATE TABLE IF NOT EXISTS `trn_resumen_historia_clinica` (
  `oid` bigint(20) NOT NULL AUTO_INCREMENT,
  `cliente_oid` bigint(20) NOT NULL,
  `profesional_oid` bigint(20) NOT NULL,
  `fecha` date NOT NULL,
  `texto` text NOT NULL,
  PRIMARY KEY (`oid`),
  KEY `cliente_oid` (`cliente_oid`),
  KEY `profesional_oid` (`profesional_oid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

ALTER TABLE `trn_resumen_historia_clinica` CHANGE `texto` `texto` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ;

ALTER TABLE `trn_turno` ADD `nomenclador_oid` INT NULL ;
