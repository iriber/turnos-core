<?php
namespace Turnos\Core\service;

use Turnos\Core\model\Ausencia;
use Turnos\Core\model\Profesional;

use Cose\Crud\service\ICrudService;

/**
 * interfaz para el servicio de Ausencia
 *  
 * @author bernardo
 *
 */
interface IAusenciaService extends ICrudService {
	
	/**
	 * Devuelve las ausencias para una fecha específica. Esto es, dada una fecha,
	 * retorna las ausencias que existen para ese día. 
	 * 
	 * @param \DateTime $fecha
	 * @param Profesional $profesional
	 */
	function getAusenciasDelDia( \DateTime $fecha, Profesional $profesional );

	/**
	 * Devuelve las ausencias vigentes dada una fecha. Esto es, dad una fecha,
	 * retorna las ausencias que aún no finalizaron.
	 * @param $fecha
	 * @param $profesional
	 */
	function getAusenciasVigentes( \DateTime $fecha, Profesional $profesional );
	
	/**
	 * Devuelve las ausencias vigentes dada un rango.
	 * @param $fechaDesde
	 * @param $fechaHAsta
	 * @param $profesional
	 */
	function getAusenciasVigentesEnRango( \DateTime $fechaDesde, \DateTime $fechaHasta, Profesional $profesional );
	
}