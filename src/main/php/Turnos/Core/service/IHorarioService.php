<?php
namespace Turnos\Core\service;

use Turnos\Core\model\Profesional;

use Cose\Crud\service\ICrudService;

/**
 * interfaz para el servicio de Horario
 *  
 * @author bernardo
 *
 */
interface IHorarioService extends ICrudService {
	
	function getHorariosDelDia( \DateTime $fecha, Profesional $profesional);
	
	function getHorariosDelProfesional( Profesional $profesional);
	
}