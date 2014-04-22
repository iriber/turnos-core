<?php
namespace Turnos\Core\dao;

use Cose\exception\DAOException;

use Cose\Crud\dao\ICrudDAO;

use Turnos\Core\model\Profesional;

/**
 * Interface del DAO de Stats
 *  
 * @author bernardo
 *
 */
interface IStatsDAO{

	function getClientesPorMes($anio);
}
