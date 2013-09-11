<?php
namespace Turnos\Core\criteria;

use Cose\criteria\impl\Criteria;

/**
 * criteria de Horario
 *  
 * @author bernardo
 *
 */
class HorarioCriteria extends Criteria{

	private $dia;
	
	private $profesional;


	public function getDia()
	{
	    return $this->dia;
	}

	public function setDia($dia)
	{
	    $this->dia = $dia;
	}

	public function getProfesional()
	{
	    return $this->profesional;
	}

	public function setProfesional($profesional)
	{
	    $this->profesional = $profesional;
	}
}