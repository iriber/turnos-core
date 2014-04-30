<?php
namespace Turnos\Core\criteria;

use Cose\criteria\impl\Criteria;

/**
 * criteria de ClienteObraSocial
 *  
 * @author bernardo
 *
 */
class ClienteObraSocialCriteria extends Criteria{

	private $oidNotEqual;
	
	private $obraSocial;
	
	private $cliente;
	
	private $planObraSocial;
	
	private $nroObraSocial;
	
	private $tipoAfiliado;

	private $obraSocialNull;
	
	private $planObraSocialNull;
	
	private $tipoAfiliadoNull;
	
	private $nroObraSocialEmpty;
	
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

	public function getCliente()
	{
	    return $this->cliente;
	}

	public function setCliente($cliente)
	{
	    $this->cliente = $cliente;
	}

	public function getPlanObraSocial()
	{
	    return $this->planObraSocial;
	}

	public function setPlanObraSocial($planObraSocial)
	{
	    $this->planObraSocial = $planObraSocial;
	}

	public function getNroObraSocial()
	{
	    return $this->nroObraSocial;
	}

	public function setNroObraSocial($nroObraSocial)
	{
	    $this->nroObraSocial = $nroObraSocial;
	}

	public function getTipoAfiliado()
	{
	    return $this->tipoAfiliado;
	}

	public function setTipoAfiliado($tipoAfiliado)
	{
	    $this->tipoAfiliado = $tipoAfiliado;
	}

	public function getObraSocialNull()
	{
	    return $this->obraSocialNull;
	}

	public function setObraSocialNull($obraSocialNull)
	{
	    $this->obraSocialNull = $obraSocialNull;
	}

	public function getPlanObraSocialNull()
	{
	    return $this->planObraSocialNull;
	}

	public function setPlanObraSocialNull($planObraSocialNull)
	{
	    $this->planObraSocialNull = $planObraSocialNull;
	}

	public function getTipoAfiliadoNull()
	{
	    return $this->tipoAfiliadoNull;
	}

	public function setTipoAfiliadoNull($tipoAfiliadoNull)
	{
	    $this->tipoAfiliadoNull = $tipoAfiliadoNull;
	}

	public function getNroObraSocialEmpty()
	{
	    return $this->nroObraSocialEmpty;
	}

	public function setNroObraSocialEmpty($nroObraSocialEmpty)
	{
	    $this->nroObraSocialEmpty = $nroObraSocialEmpty;
	}
}