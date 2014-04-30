<?php
namespace Turnos\Core\service;

use Turnos\Core\model\ClienteObraSocial;

use Turnos\Core\model\PlanObraSocial;

use Turnos\Core\model\ObraSocial;

use Turnos\Core\model\Cliente;

use Cose\Crud\service\ICrudService;

/**
 * interfaz para el servicio de ClienteObraSocial
 *  
 * @author bernardo
 * @since 28/04/2013
 */
interface IClienteObraSocialService extends ICrudService {
	
	/**
	 * retorna las obras sociales de un cliente.
	 * @param Cliente $cliente
	 */
	public function getObrasSociales( Cliente $cliente );
	
	
	public function getByObraSocialPlan( Cliente $cliente, ObraSocial $obraSocial=null, PlanObraSocial $planObraSocial=null, $nroObraSocial="", $tipoAfiliado=null );
	
	public function chequearObraSocial( ClienteObraSocial $clienteOS );
}