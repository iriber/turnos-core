<?php
namespace Turnos\Core\criteria;

use Cose\criteria\impl\Criteria;

/**
 * criteria de persona
 *  
 * @author bernardo
 *
 */
class ClienteCriteria extends Criteria{

	private $oidNotEqual;
	
	private $nombre;

	private $domicilio;

	private $nroHistoriaClinica;

	private $nroObraSocial;
	
	private $obraSocialNombre;
		
	private $nroDocumento;
	
	private $tipoDocumento;
	
	private $nombreEqual;
	
	public function getNombre()
	{
	    return $this->nombre;
	}

	public function setNombre($nombre)
	{
	    $this->nombre = $nombre;
	}

	public function getNroHistoriaClinica()
	{
	    return $this->nroHistoriaClinica;
	}

	public function setNroHistoriaClinica($nroHistoriaClinica)
	{
	    $this->nroHistoriaClinica = $nroHistoriaClinica;
	}

	public function getNroObraSocial()
	{
	    return $this->nroObraSocial;
	}

	public function setNroObraSocial($nroObraSocial)
	{
	    $this->nroObraSocial = $nroObraSocial;
	}

	public function getObraSocialNombre()
	{
	    return $this->obraSocialNombre;
	}

	public function setObraSocialNombre($obraSocialNombre)
	{
	    $this->obraSocialNombre = $obraSocialNombre;
	}

	public function getDomicilio()
	{
	    return $this->domicilio;
	}

	public function setDomicilio($domicilio)
	{
	    $this->domicilio = $domicilio;
	}

	public function getNroDocumento()
	{
	    return $this->nroDocumento;
	}

	public function setNroDocumento($nroDocumento)
	{
	    $this->nroDocumento = $nroDocumento;
	}

	public function getTipoDocumento()
	{
	    return $this->tipoDocumento;
	}

	public function setTipoDocumento($tipoDocumento)
	{
	    $this->tipoDocumento = $tipoDocumento;
	}

	public function getNombreEqual()
	{
	    return $this->nombreEqual;
	}

	public function setNombreEqual($nombreEqual)
	{
	    $this->nombreEqual = $nombreEqual;
	}


	public function getOidNotEqual()
	{
	    return $this->oidNotEqual;
	}

	public function setOidNotEqual($oidNotEqual)
	{
	    $this->oidNotEqual = $oidNotEqual;
	}
}