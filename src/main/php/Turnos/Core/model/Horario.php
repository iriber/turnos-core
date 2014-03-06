<?php

namespace Turnos\Core\model;

use Cose\model\impl\Entity;

use Turnos\Core\model\Profesional;

/**
 * Horario
 * 
 * @Entity @Table(name="trn_horario")
 * 
 * @author Bernardo
 * @since 21-05-2013
 */

class Horario extends Entity{

	//variables de instancia.

	/**
	 * @Column(type="integer")
	 * @var unknown_type
	 */
	private $dia;

	/** @Column(type="time") **/
	private $horaDesde;

	/** @Column(type="time") **/
	private $horaHasta;
	
	/** @Column(type="string") **/
	private $duracionTurno;
	
	/**
     * @ManyToOne(targetEntity="Profesional",cascade={"merge"})
     * @JoinColumn(name="profesional_oid", referencedColumnName="oid")
     * @var Profesional
     **/
	private $profesional; 


	public function __construct(){
		$this->setProfesional( new Profesional() );
	}
	
	public function __toString(){
		return DiaSemana::getLabel($this->getDia()) . " - " . TRNUtils::formatTimeToView($this->getHoraDesde()) . " - " . TRNUtils::formatTimeToView($this->getHoraHasta());
	}

	public function getDia()
	{
	    return $this->dia;
	}

	public function setDia($dia)
	{
	    $this->dia = $dia;
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

	public function getDuracionTurno()
	{
	    return $this->duracionTurno;
	}

	public function setDuracionTurno($duracionTurno)
	{
	    $this->duracionTurno = $duracionTurno;
	}
	
	public function incluyeHora( \DateTime $hora ){
		
		$incluye = false;
		
		if( $hora == null  )
			$incluye = false;
			
			
		if( ($this->getHoraDesde() <= $hora)  && ($this->getHoraHasta() > $hora) )
			$incluye = true;
		
		return $incluye;
		
	}
}
?>
