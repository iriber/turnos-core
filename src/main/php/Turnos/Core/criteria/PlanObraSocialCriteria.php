<?php
namespace Turnos\Core\criteria;

use Cose\criteria\impl\Criteria;

/**
 * criteria de PlanObraSocial
 *  
 * @author bernardo
 * @since 24/04/2014
 *
 */
class PlanObraSocialCriteria extends Criteria{

	private $oidNotEqual;
	
	private $obraSocial;
	
	private $nombre;

	private $nombreEqual;
		
	public function getOidNotEqual()
	{
	    return $this->oidNotEqual;
	}

	public function setOidNotEqual($oidNotEqual)
	{
	    $this->oidNotEqual = $oidNotEqual;
	}

	public function getObraSocial()
	{
	    return $this->obraSocial;
	}

	public function setObraSocial($obraSocial)
	{
	    $this->obraSocial = $obraSocial;
	}


	public function getNombre()
	{
	    return $this->nombre;
	}

	public function setNombre($nombre)
	{
	    $this->nombre = $nombre;
	}

	public function getNombreEqual()
	{
	    return $this->nombreEqual;
	}

	public function setNombreEqual($nombreEqual)
	{
	    $this->nombreEqual = $nombreEqual;
	}
}