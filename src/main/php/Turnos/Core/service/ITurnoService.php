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
	
	function finalizarTurno($turnoOid);
	
	function asignarTurno($turnoOid);
	
	function turnoEnSala($turnoOid);
	
	function getTurnosCliente( Cliente $cliente);
}