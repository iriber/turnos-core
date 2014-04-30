<?php
namespace Turnos\Core\service;

use Turnos\Core\model\ObraSocial;

use Cose\Crud\service\ICrudService;

/**
 * interfaz para el servicio de PlanObraSocial
 *  
 * @author bernardo
 * @since 24/04/2013
 */
interface IPlanObraSocialService extends ICrudService {
	
	/**
	 * retorna los planes de una obra social.
	 * @param $obraSocial
	 */
	public function getPlanes( ObraSocial $obraSocial );
}