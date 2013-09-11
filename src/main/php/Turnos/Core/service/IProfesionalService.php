<?php
namespace Turnos\Core\service;

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
}