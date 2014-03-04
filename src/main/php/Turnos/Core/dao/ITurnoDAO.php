<?php
namespace Turnos\Core\dao;

use Cose\exception\DAOException;

use Cose\Crud\dao\ICrudDAO;

use Turnos\Core\model\Profesional;

/**
 * Interface del DAO de Turno
 *  
 * @author bernardo
 *
 */
interface ITurnoDAO extends ICrudDAO {

	function getTurnosDelDia($dia, Profesional $profesional);
	
	function getTurnosAtendiendo($fecha);
}
