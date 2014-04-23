update `trn_practica` 
set profesional_oid=null
where profesional_oid not in (select oid from trn_profesional);

UPDATE `trn_turno` SET profesional_oid = NULL WHERE profesional_oid NOT IN (
SELECT oid
FROM trn_profesional
);
