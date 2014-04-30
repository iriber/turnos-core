<?php
namespace Turnos\Core\service;

use Cose\Crud\service\ICrudService;
use Turnos\Core\model\Cliente;

/**
 * interfaz para el servicio de cliente
 *  
 * @author bernardo
 *
 */
interface IClienteService extends ICrudService {
	
	public function getByHistoriaClinica( $nroHistoriaClinica );
	
	
}