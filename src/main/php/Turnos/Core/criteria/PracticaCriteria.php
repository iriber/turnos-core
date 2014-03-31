<?php
namespace Turnos\Core\criteria;

use Cose\criteria\impl\Criteria;

/**
 * criteria de práctica
 *  
 * @author bernardo
 *
 */
class PracticaCriteria extends Criteria{

	private $profesional;

	private $cliente;
	
	private $fecha;
	
	private $fechaDesde;
	
	private $fechaHasta;
	
	private $obraSocial;
	
	private $nomenclador;
	
	public function getProfesional()
	{
	    return $this->profesional;
	}

	public function setProfesional($profesional)
	{
	    $this->profesional = $profesional;
	}

	public function getCliente()
	{
	    return $this->cliente;
	}

	public function setCliente($cliente)
	{
	    $this->cliente = $cliente;
	}

	public function getFecha()
	{
	    return $this->fecha;
	}

	public function setFecha($fecha)
	{
	    $this->fecha = $fecha;
	}

	public function getFechaDesde()
	{
	    return $this->fechaDesde;
	}

	public function setFechaDesde($fechaDesde)
	{
	    $this->fechaDesde = $fechaDesde;
	}

	public function getFechaHasta()
	{
	    return $this->fechaHasta;
	}

	public function setFechaHasta($fechaHasta)
	{
	    $this->fechaHasta = $fechaHasta;
	}

	public function getObraSocial()
	{
	    return $this->obraSocial;
	}

	public function setObraSocial($obraSocial)
	{
	    $this->obraSocial = $obraSocial;
	}

	public function getNomenclador()
	{
	    return $this->nomenclador;
	}

	public function setNomenclador($nomenclador)
	{
	    $this->nomenclador = $nomenclador;
	}
}

