<?php
namespace Turnos\Core\dao;

use Cose\exception\DAOException;

use Cose\Crud\dao\ICrudDAO;

use Turnos\Core\model\Profesional;
/**
 * Interface del DAO de Horario
 *  
 * @author bernardo
 *
 */
interface IHorarioDAO extends ICrudDAO {

	function getHorariosDelDia($dia, Profesional $profesional);
	
	function getHorariosDelProfesional(Profesional $profesional);
}
