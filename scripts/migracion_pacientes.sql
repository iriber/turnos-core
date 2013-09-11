use instituto_access;

INSERT INTO trn_cliente (oid, tipoDocumento, nroDocumento, nombre, domicilio, telefonoFijo,obraSocial_oid,nroObraSocial, sexo,fechaNacimiento, localidad_nombre, fechaAlta)

SELECT 
NUMERO,
if( tipodoc='DNI',1,if( tipodoc='LE',2,if( tipodoc='LC',3,null))),
NRODOC,
Nombre,
DIRECC,
telefono,
(select os.oid from trn_obra_social os where codigo=O_SOCIAL ) ,
NRO_O_S,
if( sexo='M',1,if( sexo='F',2,null)),
FECHANAC,
localidad,
STR_TO_DATE(fechaAlta,'%d/%m/%Y')
from paciente order by NUMERO;
