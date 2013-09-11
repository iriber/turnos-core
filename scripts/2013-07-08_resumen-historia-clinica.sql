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

