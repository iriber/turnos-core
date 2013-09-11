<?php
namespace Turnos\Core\criteria;

use Cose\criteria\impl\Criteria;

/**
 * criteria de turno
 *  
 * @author bernardo
 *
 */
class TurnoCriteria extends Criteria{

	private $oidNotEqual;
	
	private $profesional;

	private $cliente;
	
	private $fecha;
	
	private $fechaDesde;
	
	private $fechaHasta;
	
	private $hora;
	
	private $estadoTurno;
		
	private $estados;
	
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

	public function getHora()
	{
	    return $this->hora;
	}

	public function setHora($hora)
	{
	    $this->hora = $hora;
	}

	public function getEstadoTurno()
	{
	    return $this->estadoTurno;
	}

	public function setEstadoTurno($estadoTurno)
	{
	    $this->estadoTurno = $estadoTurno;
	}



	public function getOidNotEqual()
	{
	    return $this->oidNotEqual;
	}

	public function setOidNotEqual($oidNotEqual)
	{
	    $this->oidNotEqual = $oidNotEqual;
	}

	public function getEstados()
	{
	    return $this->estados;
	}

	public function setEstados($estados)
	{
	    $this->estados = $estados;
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