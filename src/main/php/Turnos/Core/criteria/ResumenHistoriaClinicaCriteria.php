<?php
namespace Turnos\Core\criteria;

use Cose\criteria\impl\Criteria;


/**
 * criteria de ResumenHistoriaClinica
 *  
 * @author bernardo
 * @since 19/03/2014
 *
 */
class ResumenHistoriaClinicaCriteria extends Criteria{

	private $profesional;

	private $cliente;
	
	private $fecha;
	
	private $fechaDesde;
	
	private $fechaHasta;
	
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

}