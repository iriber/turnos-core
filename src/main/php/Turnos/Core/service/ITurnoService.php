<?php
namespace Turnos\Core\service;

use Turnos\Core\model\Cliente;

use Turnos\Core\model\Profesional;

use Cose\Crud\service\ICrudService;

/**
 * interfaz para el servicio de Turno
 *  
 * @author bernardo
 *
 */
interface ITurnoService extends ICrudService {
	
	function getTurnosDelDia( \DateTime $fecha, Profesional $profesional=null);
		
	function iniciarTurno($turnoOid);
	
	/**
	 * se finaliza un turno
	 * @CoseSecurity( permission="finalizar_turno")  
	 * @param $turnoOid
	 */
	function finalizarTurno($turnoOid);

	function asignarTurno($turnoOid);
	
	function turnoEnSala($turnoOid);

	/**
	 * se recuperan los turnos de un cliente.
	 * @param Cliente $cliente
	 */
	function getTurnosCliente( Cliente $cliente);
}