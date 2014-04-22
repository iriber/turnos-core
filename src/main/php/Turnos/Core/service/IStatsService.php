<?php
namespace Turnos\Core\service;

use Turnos\Core\model\Cliente;

use Turnos\Core\model\Profesional;

use Cose\service\IService;

/**
 * interfaz para estadísticas
 *  
 * @author bernardo
 *
 */
interface IStatsService extends IService {
	
	/**
	 * obtiene la cantidad de clientes por mes
	 * 
	 * @return array [mes] = cantidad
	 */
	function getClientesPorMes( $anio );
}