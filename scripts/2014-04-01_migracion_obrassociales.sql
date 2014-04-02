CREATE TABLE IF NOT EXISTS `trn_cliente_obra_social` (
  `oid` bigint(20) NOT NULL AUTO_INCREMENT,
  `cliente_oid` bigint(20) DEFAULT NULL,
  `obraSocial_oid` int(11) DEFAULT NULL,
  `nroObraSocial` varchar(100) DEFAULT NULL,
  `tipoAfiliado` int(11) DEFAULT NULL,
  PRIMARY KEY (`oid`),
  KEY `cliente_oid` (`cliente_oid`),
  KEY `obraSocial_oid` (`obraSocial_oid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


insert into trn_cliente_obra_social (cliente_oid, obraSocial_oid, nroObraSocial)
SELECT oid, obraSocial_oid, nroObraSocial FROM `trn_cliente`;

update  trn_cliente C
set clienteObraSocial_oid = ( SELECT oid FROM `trn_cliente_obra_social` COS where COS.cliente_oid = C.oid ORDER by oid DESC limit 1);

update trn_turno  T
set clienteObraSocial_oid = ( SELECT oid FROM `trn_cliente_obra_social` COS where COS.cliente_oid = T.cliente_oid AND T.`nroObraSocial`= COS.`nroObraSocial` AND T.`obraSocial_oid` = COS.`obraSocial_oid`) ;


update trn_practica  P
set clienteObraSocial_oid = ( SELECT oid FROM `trn_cliente_obra_social` COS where COS.cliente_oid = P.cliente_oid AND P.`obraSocial_oid` = COS.`obraSocial_oid`) ;

update trn_turno set nomenclador_oid=420102;
