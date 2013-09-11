<?php
namespace Turnos\Core\model;

use Cose\model\impl\Entity;

use Turnos\Core\model\Cliente,
	Turnos\Core\model\Profesional,
	Turnos\Core\model\ObraSocial,
	Turnos\Core\model\EstadoTurno;

/**
 * Turno
 * 
 * @Entity @Table(name="trn_turno")
 * 
 * @author Bernardo
 * @since 21-05-2013
 */

class Turno extends Entity {

	//variables de instancia.

	/**
	 * @Column(type="time")
	 * @var string
	 */
	private $hora;

	/**
	 * @Column(type="date")
	 * @var \DateTime
	 */
	private $fecha;

	/**
	 * @Column(type="float", nullable=true)
	 * @var float
	 */
	private $importe;

	/**
     * @ManyToOne(targetEntity="Profesional",cascade={"merge"})
     * @JoinColumn(name="profesional_oid", referencedColumnName="oid")
     * @var Profesional
     **/
	private $profesional;

	/**
     * @ManyToOne(targetEntity="Cliente",cascade={"merge"}, fetch="LAZY")
     * @JoinColumn(name="cliente_oid", referencedColumnName="oid")
     * @var Cliente
     **/
	private $cliente;

	/**
	 * sólo usado por la migración para los turnos
	 * que no tenían paciente asignado. se agregó
	 * para que queda un descripción de la persona
	 * que tomó el turno. 
	 * @Column(type="string", nullable=true)
	 * @var string
	 */
	private $nombre;
	
	/**
	 * @Column(type="integer")
	 * @var EstadoTurno
	 */
	private $estado;
	
	
	/**
     * @ManyToOne(targetEntity="ObraSocial",cascade={"merge"})
     * @JoinColumn(name="obraSocial_oid", referencedColumnName="oid")
     **/
	private $obraSocial;
	
	/**
	 * @Column(type="string", nullable=true)
	 * @var string
	 */
	private $nroObraSocial;


	public function __construct(){
		 
		$this->profesional = null;
		$this->cliente = null;
		$this->estado = EstadoTurno::Asignado;
		$this->obraSocial = null; 
		
	}


	public function __toString()
	{
		$r = $this->getFecha()->format("d-m-Y") . " - " . $this->getHora()->format("H:i") . " - " . $this->getProfesional()  ;
		
		if( $this->getCliente() != null )
			$r .=  " - " . $this->getCliente();
		
		/*	
		$os =	$this->getObraSocial();
		if( !empty($os)  ){
			$n = $os->getNombre();
			if(!empty($n))
				$r .=  " - $n";
		}*/
		$r .= " - " . $this->getObraSocial()->getOid();	
			
		return $r;
		
	}


	public function getHora()
	{
	    return $this->hora;
	}

	public function setHora($hora)
	{
	    $this->hora = $hora;
	}

	public function getFecha()
	{
	    return $this->fecha;
	}

	public function setFecha($fecha)
	{
	    $this->fecha = $fecha;
	}

	public function getImporte()
	{
	    return $this->importe;
	}

	public function setImporte($importe)
	{
	    $this->importe = $importe;
	}

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
		
		if(!empty($cliente))
	    $this->cliente = $cliente;
	}

	public function getEstado()
	{
	    return $this->estado;
	}

	public function setEstado($estado)
	{
	    $this->estado = $estado;
	}

	public function getObraSocial()
	{
	    return $this->obraSocial;
	}

	public function setObraSocial($obraSocial)
	{
	    $this->obraSocial = $obraSocial;
	}

	public function getNroObraSocial()
	{
	    return $this->nroObraSocial;
	}

	public function setNroObraSocial($nroObraSocial)
	{
	    $this->nroObraSocial = $nroObraSocial;
	}

	public function getNombre()
	{
	    return $this->nombre;
	}

	public function setNombre($nombre)
	{
	    $this->nombre = $nombre;
	}

}
?>