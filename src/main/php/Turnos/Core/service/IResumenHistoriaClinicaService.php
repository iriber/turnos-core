<?php
namespace Turnos\Core\service;

use Turnos\Core\model\Cliente;

use Cose\Crud\service\ICrudService;

/**
 * interfaz para el servicio de ResumenHistoriaClinica
 *  
 * @author bernardo
 * @since 19/03/2014
 *
 */
interface IResumenHistoriaClinicaService extends ICrudService {

	function getResumenHistoriaClinica( Cliente $cliente );
	
}