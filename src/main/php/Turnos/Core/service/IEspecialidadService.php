<?php
namespace Turnos\Core\service;

use Cose\Crud\service\ICrudService;

/**
 * interfaz para el servicio de Especialidad
 *  
 * @author bernardo
 *
 */
interface IEspecialidadService extends ICrudService {

	
	function getByNombre( $nombre );
}