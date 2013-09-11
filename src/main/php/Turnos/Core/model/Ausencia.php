<?php

namespace Turnos\Core\model;

use Cose\model\impl\Entity;

use Turnos\Core\model\Profesional;

/**
 * Define un rango de horarios y fechas 
 * donde el profesional se encuentrará ausente.
 * 
 * @Entity @Table(name="trn_ausencia")
 * 
 * @author Bernardo
 * @since 28-08-2013
 */

class Ausencia extends Entity{

	//variables de instancia.

	/**
	 * @Column(type="date")
	 * @var \Datetime
	 */
	private $fechaDesde;
	
	/**
	 * @Column(type="date", nullable=true)
	 * @var \Datetime
	 */
	private $fechaHasta;
	
	/** @Column(type="time", nullable=true) **/
	private $horaDesde;

	/** @Column(type="time", nullable=true) **/
	private $horaHasta;
	
	/**
     * @ManyToOne(targetEntity="Profesional",cascade={"merge"})
     * @JoinColumn(name="profesional_oid", referencedColumnName="oid")
     * @var Profesional
     **/
	private $profesional; 

	/**
	 * @Column(type="string", nullable=true)
	 * @var string
	 */
	private $observaciones;

	public function __construct(){
		$this->setProfesional( new Profesional() );
	}
	
	public function __toString(){
		return TRNUtils::formatDateToView($this->getFecha()) . " - " . TRNUtils::formatTimeToView($this->getHoraDesde()) . " - " . TRNUtils::formatTimeToView($this->getHoraHasta());
	}


	public function getHoraDesde()
	{
	    return $this->horaDesde;
	}

	public function setHoraDesde($horaDesde)
	{
	    $this->horaDesde = $horaDesde;
	}

	public function getHoraHasta()
	{
	    return $this->horaHasta;
	}

	public function setHoraHasta($horaHasta)
	{
	    $this->horaHasta = $horaHasta;
	}

	public function getProfesional()
	{
	    return $this->profesional;
	}

	public function setProfesional($profesional)
	{
	    $this->profesional = $profesional;
	}
	
	public function horaDisponible( \Datetime $hora ){
		
		$disponible = false;
		
		if(!empty($this->horaDesde) )
			$disponible = $this->getHoraDesde() > $hora;
			
		if(!empty($this->horaHasta) )
			$disponible = $this->getHoraHasta() <= $hora;
			
		return $disponible ;
			
	}

	public function isVigente( \Datetime $fecha, \Datetime $hora ){
		
		$vigente = false;
		
		if( $this->isPorFecha() )
		
			$vigente = $this->getFechaDesde()->format("Ymd") == $fecha->format("Ymd") ;
			 
		elseif ($this->isPorRangoFecha()){

			$vigente = ( $this->getFechaDesde() <= $fecha ) && ( $this->getFechaHasta() >= $fecha );
			
		}elseif ($this->isPorFechaHorario()) {
			
			$vigente = $this->getFechaDesde()->format("Ymd") == $fecha->format("Ymd") ;
			if( $vigente )
				$vigente = ! $this->horaDisponible($hora);
			
		}elseif ($this->isPorRangoFechaHorario()) {
			$vigente = ( $this->getFechaDesde() <= $fecha ) && ( $this->getFechaHasta() >= $fecha );
			if( $vigente )
				$vigente = ! $this->horaDisponible($hora);
		}
		
		return $vigente;
			
	}
	
	
	public function getObservaciones()
	{
	    return $this->observaciones;
	}

	public function setObservaciones($observaciones)
	{
	    $this->observaciones = $observaciones;
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
	
	public function isPorFecha(){
		
		return empty($this->fechaHasta) && empty($this->horaDesde) && empty($this->horaHasta);
		
	}
	
	public function isPorFechaHorario(){
		
		return empty($this->fechaHasta) && !empty($this->horaDesde) && !empty($this->horaHasta);
		
	}
	
	public function isPorRangoFecha(){
		
		return !empty($this->fechaHasta) && empty($this->horaDesde) && empty($this->horaHasta);
		
	}
	
	public function isPorRangoFechaHorario(){
		
		return !empty($this->fechaHasta) && !empty($this->horaDesde) && !empty($this->horaHasta);
		
	}
}
?>
