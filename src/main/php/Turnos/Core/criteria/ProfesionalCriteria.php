<?php
namespace Turnos\Core\criteria;

use Cose\criteria\impl\Criteria;
use Cose\Security\model\User;
/**
 * criteria de profesional
 *  
 * @author bernardo
 *
 */
class ProfesionalCriteria extends Criteria{

	private $nombre;
	
	private $user;

	public function getNombre()
	{
	    return $this->nombre;
	}

	public function setNombre($nombre)
	{
	    $this->nombre = $nombre;
	}
	
	

	public function getUser()
	{
	    return $this->user;
	}

	public function setUser($user)
	{
	    $this->user = $user;
	}
}