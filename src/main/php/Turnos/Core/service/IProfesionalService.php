<?php
namespace Turnos\Core\service;

use Turnos\Core\model\Profesional;

use Turnos\Core\model\Especialidad;

use Cose\Crud\service\ICrudService;

use Cose\Security\model\User;

/**
 * interfaz para el servicio de Profesional
 *  
 * @author bernardo
 *
 */
interface IProfesionalService extends ICrudService {

	function getProfesionalByUser(User $user);
	
	function getProfesionalesByEspecialidad(Especialidad $especialidad);
	
	function hasEspecialidad( Profesional $profesional, Especialidad $especialidad );
}