<?php
namespace Turnos\Core\criteria;

use Cose\criteria\impl\Criteria;

/**
 * criteria de nomenclador
 *  
 * @author bernardo
 *
 */
class NomencladorCriteria extends Criteria{


	private $oidNotEqual;
	private $codigo;
	private $nombre;
	private $nombreEqual;
	
	public function getNombre()
	{
	    return $this->nombre;
	}

	public function setNombre($nombre)
	{
	    $this->nombre = $nombre;
	}

	public function getCodigo()
	{
	    return $this->codigo;
	}

	public function setCodigo($codigo)
	{
	    $this->codigo = $codigo;
	}

	public function getOidNotEqual()
	{
	    return $this->oidNotEqual;
	}

	public function setOidNotEqual($oidNotEqual)
	{
	    $this->oidNotEqual = $oidNotEqual;
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

