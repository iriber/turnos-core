<?php
namespace Turnos\Core\criteria;

use Cose\criteria\impl\Criteria;

/**
 * criteria de Ausencia
 *  
 * @author bernardo
 *
 */
class AusenciaCriteria extends Criteria{

	/**
	 * para filtar por una fecha dentro del rango de la ausencia
	 * fechaDesde <= fecha <= fechaHasta.
	 * @var \Datetime
	 */
	private $fecha;
	
	/**
	 * dada la fecha se chequea si la ausencia está
	 * vigente
	 * @var \Datetime
	 */
	private $fechaVigencia;
	
	/**
	 * para filtar exactamente por fecha desde.
	 * @var \Datetime
	 */
	private $fechaDesde;
	
	/**
	 * para filtar exactamente por fecha hasta.
	 * @var \Datetime
	 */
	private $fechaHasta;
	
	private $profesional;

	private $oidNotEqual;

	/**
	 * limite inferior
	 * para ausencias vigentes en un rango
	 * @var \Datetime
	 */
	private $fechaVigenciaDesde;
	
	/**
	 * limite superior
	 * para ausencias vigentes en un rango
	 * @var \Datetime
	 */
	private $fechaVigenciaHasta;
	
	public function getProfesional()
	{
	    return $this->profesional;
	}

	public function setProfesional($profesional)
	{
	    $this->profesional = $profesional;
	}

	public function getFecha()
	{
	    return $this->fecha;
	}

	public function setFecha($fecha)
	{
	    $this->fecha = $fecha;
	}

	public function getOidNotEqual()
	{
	    return $this->oidNotEqual;
	}

	public function setOidNotEqual($oidNotEqual)
	{
	    $this->oidNotEqual = $oidNotEqual;
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

	public function getFechaVigencia()
	{
	    return $this->fechaVigencia;
	}

	public function setFechaVigencia($fechaVigencia)
	{
	    $this->fechaVigencia = $fechaVigencia;
	}

	public function getFechaVigenciaDesde()
	{
	    return $this->fechaVigenciaDesde;
	}

	public function setFechaVigenciaDesde($fechaVigenciaDesde)
	{
	    $this->fechaVigenciaDesde = $fechaVigenciaDesde;
	}

	public function getFechaVigenciaHasta()
	{
	    return $this->fechaVigenciaHasta;
	}

	public function setFechaVigenciaHasta($fechaVigenciaHasta)
	{
	    $this->fechaVigenciaHasta = $fechaVigenciaHasta;
	}
}