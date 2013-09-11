

ALTER TABLE `nomencla` ADD INDEX ( `Nombre` ) ;

ALTER TABLE `practica` ADD INDEX ( `codigo_practica` ) ;



/*migración de MEDICOS*/
INSERT INTO trn_profesional (oid, nombre, domicilio, telefonoFijo, categoria, matricula)
SELECT codigo, nombre, domicilio, telefono, if( categoria='BASICO',1,2),matricula from medico;

/*migración OBRAS SOCIALES*/
insert into trn_obra_social (oid, nombre, codigo, domicilio, cuit, circulo )
SELECT `CODIGO`,`oNOMBRE`,`CODIGOTXT`,`DOMICILIO`,`CUIT`, `circulo` FROM `obras`;

/*migración localidades*/
insert into trn_localidad(nombre)
SELECT distinct(localidad) FROM `paciente`;

/***********************************
  PACIENTES

  DNI - 1
  LE - 2
  LC - 3
*/


/*chequear numero repetido*/
SELECT count( Numero ) AS cantidad, numero
FROM `paciente`
GROUP BY Numero
HAVING cantidad >1;

/*borrar pacientes mal formados*/

delete from paciente where NUMERO is null;

delete from paciente where nombre is null;

delete from paciente where Numero in(9198,9270,x,x,x);


/*insertar los pacientes*/
INSERT INTO trn_cliente (oid, tipoDocumento, nroDocumento, nombre, domicilio, telefonoFijo,obraSocial_oid,nroObraSocial, sexo,fechaNacimiento, localidad_nombre, fechaAlta,nroHistoriaClinica)

SELECT 
NUMERO,
if( tipodoc='DNI',1,if( tipodoc='LE',2,if( tipodoc='LC',3,null))),
NRODOC,
Nombre,
DIRECC,
telefono,
(select os.oid from trn_obra_social os where codigo=O_SOCIAL ),
NRO_O_S,
if( sexo='M',1,if( sexo='F',2,null)),
FECHANAC,
localidad,
STR_TO_DATE(fechaAlta,'%d/%m/%Y'),
NUMEROHC
from paciente order by NUMERO;

/*actualizar NUMEROHC*/
update trn_cliente C
set nroHistoriaClinica = (select NUMEROHC from paciente where NUMERO=C.oid)

/* fecha Alta 0000-00-00 a null */
update `trn_cliente` set fechaAlta=null where fechaAlta = '0000-00-00';

/* fecha nacimiento 0000-00-00 a null */
update `trn_cliente` set fechaNacimiento=null where fechaNacimiento = '0000-00-00';

/*chequear nomencla repetido*/
SELECT count( CODigo ) AS cantidad, CODigo
FROM `nomencla`
GROUP BY CODigo
HAVING cantidad >1;

/* este está 2 veces: 180122 */

/*revisar si existen nomencladores sin nombre usados en las práctica, ahora hay 0*/
SELECT * from practica where `codigo.practica` in ( select CODigo FROM `nomencla` where Nombre is null);


/*migración nomenclador*/
insert into trn_nomenclador (nombre, codigo, oid )
SELECT `Nombre`,`CODigo`,`CODIGO0` FROM `nomencla` where Nombre is not null;

/*****************************************************

 TURNOS

 Estado = [ A => 2, S => 1. "" => 4]

*/

/*existen turnos vacíos, los elimino*/
delete from turno
where (numero = 0 AND Nombre is null and Apellido is null) OR matricula is null;


/*varios con obra I. O. M. A., los paso a IOMA*/
update turno
set Obra= 'IOMA'
where Obra='I. O. M. A.';

insert into trn_turno (fecha,hora,profesional_oid,cliente_oid,obraSocial_oid,nroObraSocial,estado, importe)
SELECT `Dia` , 
`Hora` , 
(SELECT CODIGO FROM medico M WHERE M.`Matricula` = T.`Matricula`) AS medico, 
`Numero` as paciente,
(SELECT oid FROM trn_obra_social OS WHERE OS.nombre = T.`Obra` limit 1) AS obra_oid, 
NumObra,
if( Estado='A',4,if( Estado='S',1,2)), Importe
FROM `turno` T
WHERE matricula NOT
IN ( 11111, 3467, 0 ) and Numero not in (-1,0)

/*agrego los que no tienen paciente asignado*/
insert into trn_turno (fecha,hora,profesional_oid,nombre,obraSocial_oid,nroObraSocial,estado, importe)
SELECT `Dia` , 
`Hora` , 
(SELECT CODIGO FROM medico M WHERE M.`Matricula` = T.`Matricula`) AS medico, 
Apellido,
(SELECT oid FROM trn_obra_social OS WHERE OS.nombre = T.`Obra` limit 1) AS obra_oid, 
NumObra,
if( Estado='A',4,if( Estado='S',1,2)), Importe
FROM `turno` T
WHERE matricula NOT
IN ( 11111, 3467, 0 ) and Numero in (-1)


/*agrego los que no tienen paciente asignado de las otras matrículas*/
insert into trn_turno (fecha,hora,profesional_oid,nombre,obraSocial_oid,nroObraSocial,estado, importe)
SELECT `Dia` , 
`Hora` , 
(SELECT CODIGO FROM medico M WHERE M.`Matricula` = T.`Matricula` limit 1) AS medico, 
Apellido,
(SELECT oid FROM trn_obra_social OS WHERE OS.nombre = T.`Obra` limit 1) AS obra_oid, 
NumObra,
if( Estado='A',4,if( Estado='S',1,2)), Importe
FROM `turno` T
WHERE matricula 
IN ( 11111, 3467, 0 ) and Numero in (-1)

/*agrego los que no tienen paciente =0*/
insert into trn_turno (fecha,hora,profesional_oid,nombre,obraSocial_oid,nroObraSocial,estado, importe)
SELECT `Dia` , 
`Hora` , 
(SELECT CODIGO FROM medico M WHERE M.`Matricula` = T.`Matricula` limit 1) AS medico, 
Apellido,
(SELECT oid FROM trn_obra_social OS WHERE OS.nombre = T.`Obra` limit 1) AS obra_oid, 
NumObra,
if( Estado='A',4,if( Estado='S',1,2)), Importe
FROM `turno` T
WHERE  Numero =0


/* seteamos a null los que tienen fecha 0000-00-00*/
update `trn_turno` set fecha=null where fecha = '0000-00-00';

/***************************************
	PRÁCTICAS

 estado = D | F | P
*/
insert into trn_practica( cliente_oid, fecha, profesional_oid,observaciones,obraSocial_oid, nomenclador_oid,oid)
SELECT 
Paciente, 
Fecha, 
Medico, 
Texto, 
cobertura, 
(select oid from trn_nomenclador where codigo = codigo_practica) as nomenclador_oid,
idpractica 
FROM `practica`

/*where costo>0 => NADA*/

/****************************
 *  horarios de médicos
*/
insert into trn_horario(duracionTurno, profesional_oid,dia,horaDesde,horaHasta)
SELECT 
15,
(select codigo from medico M where M.matricula=H.MATRICULA ) as medico,
if( diasemana='DOMINGO',0,if( diasemana='LUNES',1,if( diasemana='MARTES',2,if( diasemana='MIERCOLES',3,if( diasemana='JUEVES',4,if( diasemana='VIERNES',5,if( diasemana='SABADO',6,null))))))) as dia,
DATE_FORMAT(horainicio,'%H:%i')  as inicio,
DATE_FORMAT(horafin,'%H:%i')  as fin
FROM `horario` H
where exists (select codigo from medico M2 where M2.matricula=H.MATRICULA)
ORDER BY H.`MATRICULA`, (if( diasemana='DOMINGO',0,if( diasemana='LUNES',1,if( diasemana='MARTES',2,if( diasemana='MIERCOLES',3,if( diasemana='JUEVES',4,if( diasemana='VIERNES',5,if( diasemana='SABADO',1,6)))))))), horainicio
