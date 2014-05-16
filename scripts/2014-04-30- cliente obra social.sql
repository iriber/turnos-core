/*
 1- en la tabla trn_cliente, trn_practica y trn_turno setear datos actuales

	obraSocial_oid
	nroObraSocial
	tipoAfiliado	

*/

ALTER TABLE `trn_cliente` ADD `tipoAfiliado` INT( 11 ) NULL ;
ALTER TABLE `trn_turno` ADD `tipoAfiliado` INT( 11 ) NULL ;
ALTER TABLE `trn_practica` ADD `tipoAfiliado` INT( 11 ) NULL ;
ALTER TABLE `trn_practica` ADD `nroObraSocial` VARCHAR( 100 ) NULL ;

ALTER TABLE `trn_turno` 
ADD INDEX ( `nroObraSocial` ),
ADD INDEX ( `tipoAfiliado` ),
ADD INDEX ( `obraSocial_oid` ) ;

ALTER TABLE `trn_practica` 
ADD INDEX ( `nroObraSocial` ),
ADD INDEX ( `tipoAfiliado` ) ;

/* cliente */
update trn_cliente  T
        	INNER JOIN (
        		SELECT  oid,
				obraSocial_oid,
        			nroObraSocial,
        			tipoAfiliado
        			from trn_cliente_obra_social        			
        		) A ON A.oid=T.clienteObraSocial_oid
SET T.obraSocial_oid = A.obraSocial_oid,
	T.nroObraSocial = A.nroObraSocial,
        T.tipoAfiliado = A.tipoAfiliado;


/* turno */
/*actualizo las que no tengan seteado el clienteObraSocial*/
update trn_turno  T
        	INNER JOIN (
        		SELECT  oid,
				cliente_oid,
				obraSocial_oid,
        			nroObraSocial,
        			tipoAfiliado
        			from trn_cliente_obra_social
        		) COS ON COS.obraSocial_oid=T.obraSocial_oid AND COS.cliente_oid=T.cliente_oid
SET T.clienteObraSocial_oid = COS.oid
where T.clienteObraSocial_oid is null;


/*SELECT oid, obraSocial_oid, nroObraSocial FROM `trn_turno` where  cliente_oid is not null and clienteObraSocial_oid is null;*/

/*en una tabla temporal dejamos los clienteObraSocial de los turnos*/
CREATE TABLE IF NOT EXISTS `trn_cliente_obra_social_turno_temporal` (
  `turno_oid` bigint(20) DEFAULT NULL,
  `cliente_oid` bigint(20) DEFAULT NULL,
  `obraSocial_oid` int(11) DEFAULT NULL,
  `tipoAfiliado` int(11) DEFAULT NULL,
  `nroObraSocial` varchar(100) DEFAULT NULL
) ENGINE=InnoDB  ;
ALTER TABLE `trn_cliente_obra_social_turno_temporal` 
ADD INDEX ( `turno_oid` ),
ADD INDEX ( `cliente_oid` ),
ADD INDEX ( `nroObraSocial` ),
ADD INDEX ( `obraSocial_oid` ) ;

insert into trn_cliente_obra_social_turno_temporal 
(turno_oid, cliente_oid, nroObraSocial,obraSocial_oid,tipoAfiliado)
SELECT C.oid,C.cliente_oid,COS.nroObraSocial,COS.obraSocial_oid,COS.tipoAfiliado FROM `trn_turno` C, trn_cliente_obra_social COS
where C.clienteObraSocial_oid = COS.oid 

/* lo que dejamos en la temporal, lo seteamos en la tabla turno*/

update trn_turno  T
        	INNER JOIN (
        		SELECT  turno_oid,
				obraSocial_oid,
        			nroObraSocial,
        			tipoAfiliado
        			from trn_cliente_obra_social_turno_temporal
        		) A ON A.turno_oid=T.oid
SET T.obraSocial_oid = A.obraSocial_oid,
	T.nroObraSocial = A.nroObraSocial,
        T.tipoAfiliado = A.tipoAfiliado;

/*
update trn_turno  T
        	INNER JOIN (
        		SELECT  oid,
				obraSocial_oid,
        			nroObraSocial,
        			tipoAfiliado
        			from trn_cliente_obra_social        			
        		) A ON A.oid=T.clienteObraSocial_oid and ( (T.nroObraSocial <> A.nroObraSocial) OR (T.obraSocial_oid <> A.obraSocial_oid) OR (T.tipoAfiliado <> A.tipoAfiliado) )
SET T.obraSocial_oid = A.obraSocial_oid,
	T.nroObraSocial = A.nroObraSocial,
        T.tipoAfiliado = A.tipoAfiliado;
*/

/* práctica */

/*actualizo las que no tengan seteado el clienteObraSocial*/
update trn_practica  T
        	INNER JOIN (
        		SELECT  oid,
				obraSocial_oid,
				cliente_oid,
        			nroObraSocial,
        			tipoAfiliado
        			from trn_cliente_obra_social
        		) COS ON COS.obraSocial_oid=T.obraSocial_oid AND COS.cliente_oid=T.cliente_oid
SET T.clienteObraSocial_oid = COS.oid
where T.clienteObraSocial_oid is null;


/*en una tabla temporal dejamos los clienteObraSocial de las prácticas*/
CREATE TABLE IF NOT EXISTS `trn_cliente_obra_social_practica_temporal` (
  `practica_oid` bigint(20) DEFAULT NULL,
  `cliente_oid` bigint(20) DEFAULT NULL,
  `obraSocial_oid` int(11) DEFAULT NULL,
  `tipoAfiliado` int(11) DEFAULT NULL,
  `nroObraSocial` varchar(100) DEFAULT NULL
) ENGINE=InnoDB  ;
ALTER TABLE `trn_cliente_obra_social_practica_temporal` 
ADD INDEX ( `practica_oid` ),
ADD INDEX ( `cliente_oid` ),
ADD INDEX ( `nroObraSocial` ),
ADD INDEX ( `obraSocial_oid` ) ;

insert into trn_cliente_obra_social_practica_temporal 
(practica_oid, cliente_oid, nroObraSocial,obraSocial_oid,tipoAfiliado)
SELECT C.oid,C.cliente_oid,COS.nroObraSocial,COS.obraSocial_oid,COS.tipoAfiliado FROM `trn_practica` C, trn_cliente_obra_social COS
where C.clienteObraSocial_oid = COS.oid 

/* lo que dejamos en la temporal, lo seteamos en la tabla practica*/
update trn_practica  T
        	INNER JOIN (
        		SELECT  practica_oid,
				obraSocial_oid,
        			nroObraSocial,
        			tipoAfiliado
        			from trn_cliente_obra_social_practica_temporal
        		) A ON A.practica_oid=T.oid
SET T.obraSocial_oid = A.obraSocial_oid,
	T.nroObraSocial = A.nroObraSocial,
        T.tipoAfiliado = A.tipoAfiliado;


/*
update trn_practica  T
        	INNER JOIN (
        		SELECT  oid,
				obraSocial_oid,
        			nroObraSocial,
        			tipoAfiliado
        			from trn_cliente_obra_social        			
        		) A ON A.oid=T.clienteObraSocial_oid and ( (T.nroObraSocial <> A.nroObraSocial) OR (T.obraSocial_oid <> A.obraSocial_oid) OR (T.tipoAfiliado <> A.tipoAfiliado) )
SET T.obraSocial_oid = A.obraSocial_oid,
	T.nroObraSocial = A.nroObraSocial,
        T.tipoAfiliado = A.tipoAfiliado

*/

/*
   para chequear
*/

SELECT C.oid FROM `trn_cliente` C, trn_cliente_obra_social COS
where C.clienteObraSocial_oid = COS.oid 
and ( (C.nroObraSocial <> COS.nroObraSocial) OR (C.obraSocial_oid <> COS.obraSocial_oid) OR (C.tipoAfiliado <> COS.tipoAfiliado) );

SELECT C.oid FROM `trn_turno` C, trn_cliente_obra_social COS
where C.clienteObraSocial_oid = COS.oid 
and ( (C.nroObraSocial <> COS.nroObraSocial) OR (C.obraSocial_oid <> COS.obraSocial_oid) OR (C.tipoAfiliado <> COS.tipoAfiliado) );

SELECT C.oid FROM `trn_practica` C, trn_cliente_obra_social COS
where C.clienteObraSocial_oid = COS.oid 
and ( (C.nroObraSocial <> COS.nroObraSocial) OR (C.obraSocial_oid <> COS.obraSocial_oid) OR (C.tipoAfiliado <> COS.tipoAfiliado) );

/*
  2- trabajar sobre la tabla cliente obra social
*/

CREATE TABLE IF NOT EXISTS `trn_cliente_obra_social_temporal` (
  `cliente_oid` bigint(20) DEFAULT NULL,
  `obraSocial_oid` int(11) DEFAULT NULL,
  `nroObraSocial` varchar(100) DEFAULT NULL,
  `tipoAfiliado` int(11) DEFAULT NULL

) ENGINE=InnoDB  ;
ALTER TABLE `trn_cliente_obra_social_temporal` 
ADD INDEX ( `cliente_oid` ),
ADD INDEX ( `nroObraSocial` ),
ADD INDEX ( `obraSocial_oid` ) ,
ADD INDEX ( `tipoAfiliado` ) 
;

CREATE TABLE IF NOT EXISTS `trn_cliente_obra_social_temporal_2` (
  `cliente_oid` bigint(20) DEFAULT NULL,
  `obraSocial_oid` int(11) DEFAULT NULL,
  `tipoAfiliado` int(11) DEFAULT NULL,
  `nroObraSocial` varchar(100) DEFAULT NULL

) ENGINE=InnoDB  ;
ALTER TABLE `trn_cliente_obra_social_temporal_2` 
ADD INDEX ( `cliente_oid` ),
ADD INDEX ( `tipoAfiliado` ),
ADD INDEX ( `nroObraSocial` ),
ADD INDEX ( `obraSocial_oid` ) ;

insert into trn_cliente_obra_social_temporal (cliente_oid, obraSocial_oid, nroObraSocial,tipoAfiliado)
SELECT distinct oid, obraSocial_oid, nroObraSocial,tipoAfiliado FROM `trn_cliente`;

insert into trn_cliente_obra_social_temporal (cliente_oid, obraSocial_oid, nroObraSocial,tipoAfiliado)   	
SELECT distinct cliente_oid, obraSocial_oid, nroObraSocial,tipoAfiliado FROM `trn_turno`;

insert into trn_cliente_obra_social_temporal (cliente_oid, obraSocial_oid, nroObraSocial,tipoAfiliado)
SELECT distinct cliente_oid, obraSocial_oid, nroObraSocial,tipoAfiliado FROM `trn_practica`;

insert into trn_cliente_obra_social_temporal_2 (cliente_oid, obraSocial_oid, nroObraSocial,tipoAfiliado)   	
SELECT distinct cliente_oid, obraSocial_oid, nroObraSocial,tipoAfiliado FROM `trn_cliente_obra_social_temporal`;

truncate trn_cliente_obra_social;

insert into trn_cliente_obra_social(cliente_oid, obraSocial_oid, nroObraSocial, tipoAfiliado) 
SELECT cliente_oid, obraSocial_oid, nroObraSocial,tipoAfiliado FROM `trn_cliente_obra_social_temporal_2` 
group by cliente_oid, obraSocial_oid, nroObraSocial;

/*
  3- actualizamos las tablas trn_cliente, trn_practica y trn_turno
  con el oid del clienteobrasocial correspondiente

*/

update  trn_cliente C
set clienteObraSocial_oid = 
( SELECT oid FROM `trn_cliente_obra_social` COS 
  where COS.cliente_oid = C.oid 
  and C.nroObraSocial = COS.nroObraSocial 
  and C.obraSocial_oid = COS.obraSocial_oid 
ORDER by oid DESC limit 1);

update  trn_turno C
set clienteObraSocial_oid = 
( SELECT oid FROM `trn_cliente_obra_social` COS 
  where COS.cliente_oid = C.cliente_oid 
  and C.nroObraSocial = COS.nroObraSocial 
  and C.obraSocial_oid = COS.obraSocial_oid 
ORDER by oid DESC limit 1);

update  trn_practica C
set clienteObraSocial_oid = 
( SELECT oid FROM `trn_cliente_obra_social` COS 
  where COS.cliente_oid = C.cliente_oid 
  and C.nroObraSocial = COS.nroObraSocial 
  and C.obraSocial_oid = COS.obraSocial_oid 
ORDER by oid DESC limit 1);

/* las que quedaron huérfanas*/
update  trn_practica C
set clienteObraSocial_oid = 
( SELECT oid FROM `trn_cliente_obra_social` COS 
  where COS.cliente_oid = C.cliente_oid 
  and C.obraSocial_oid = COS.obraSocial_oid 
ORDER by oid DESC limit 1);
where clienteObraSocial_oid is null and cliente_oid is not null

update  trn_turno C
set clienteObraSocial_oid = 
( SELECT oid FROM `trn_cliente_obra_social` COS 
  where COS.cliente_oid = C.cliente_oid 
  and C.obraSocial_oid = COS.obraSocial_oid 
ORDER by oid DESC limit 1);
where clienteObraSocial_oid is null and cliente_oid is not null


/* chequeos */
SELECT *
FROM `trn_turno`
WHERE cliente_oid IS NOT NULL
AND clienteObraSocial_oid IS NULL
AND obraSocial_oid IS NOT NULL;

SELECT *
FROM `trn_practica`
WHERE cliente_oid IS NOT NULL
AND clienteObraSocial_oid IS NULL
AND obraSocial_oid IS NOT NULL;
