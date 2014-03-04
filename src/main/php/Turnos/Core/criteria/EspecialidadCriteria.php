<?php
namespace Turnos\Core\criteria;

use Cose\criteria\impl\Criteria;

/**
 * criteria de Especialidad
 *  
 * @author bernardo
 *
 */
class EspecialidadCriteria extends Criteria{

	private $nombre;

	public function getNombre()
	{
	    return $this->nombre;
	}

	public function setNombre($nombre)
	{
	    $this->nombre = $nombre;
	}
}