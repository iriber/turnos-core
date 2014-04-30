<?php
namespace Turnos\Core\model;

use Cose\model\impl\Entity;

use Turnos\Core\model\Cliente,
	Turnos\Core\model\Profesional,
	Turnos\Core\model\ObraSocial,
	Turnos\Core\model\EstadoTurno,
	Turnos\Core\model\Prioridad;
	
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
	 * 
	 * aprovecho para utilizarlo cuando dan los turnos
	 * telefónicamente donde sólo indican nombre y teléfono.
	 *  
	 * @Column(type="string", nullable=true)
	 * @var string
	 */
	private $nombre;
	
	/**
	 * utilizado cuando dan los turnos
	 * telefónicamente donde sólo indican nombre y teléfono.
	 *  
	 * @Column(type="string", nullable=true)
	 * @var string
	 */
	private $telefono;
	
	/**
	 * @Column(type="integer")
	 * @var EstadoTurno
	 */
	private $estado;
	
	/**
     * @ManyToOne(targetEntity="ClienteObraSocial",cascade={"persist"})
     * @JoinColumn(name="clienteObraSocial_oid", referencedColumnName="oid")
     **/
	private $clienteObraSocial;
	
	/**
	 * @Column(type="integer")
	 * @var Prioridad
	 */
	private $prioridad;
	

	/**
	 * @Column(type="integer")
	 * @var integer
	 */
	private $duracion;
	
	/**
     * @ManyToOne(targetEntity="Nomenclador",cascade={"merge"})
     * @JoinColumn(name="nomenclador_oid", referencedColumnName="oid")
     **/
	private $nomenclador;

	
	/**
	 * @Column(type="string", nullable=true)
	 * @var string
	 */
	private $observaciones;
	
	
	
	public function __construct(){
		 
		$this->profesional = null;
		$this->cliente = null;
		$this->estado = EstadoTurno::Asignado;
		$this->clienteObraSocial = new ClienteObraSocial(); 
		$this->duracion = 15;
		$this->nomenclador = null;
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
	    if( $this->clienteObraSocial !=null )
	    return $this->clienteObraSocial->getObraSocial();
	}

	public function setObraSocial($obraSocial)
	{
		if($this->clienteObraSocial == null )
			$this->clienteObraSocial = new ClienteObraSocial();
	    $this->clienteObraSocial->setObraSocial($obraSocial);
	}

	public function getNroObraSocial()
	{
	    if( $this->clienteObraSocial !=null )
	    return $this->clienteObraSocial->getNroObraSocial();
	}

	public function setNroObraSocial($nroObraSocial)
	{
		if($this->clienteObraSocial == null )
			$this->clienteObraSocial = new ClienteObraSocial();
	    $this->clienteObraSocial->setNroObraSocial($nroObraSocial);
	}

	public function getNombre()
	{
	    return $this->nombre;
	}

	public function setNombre($nombre)
	{
	    $this->nombre = $nombre;
	}


	public function getPrioridad()
	{
	    return $this->prioridad;
	}

	public function setPrioridad($prioridad)
	{
	    $this->prioridad = $prioridad;
	}

	public function getDuracion()
	{
	    return $this->duracion;
	}

	public function setDuracion($duracion)
	{
	    $this->duracion = $duracion;
	}

	public function getTelefono()
	{
	    return $this->telefono;
	}

	public function setTelefono($telefono)
	{
	    $this->telefono = $telefono;
	}

	public function getNomenclador()
	{
	    return $this->nomenclador;
	}

	public function setNomenclador($nomenclador)
	{
	    $this->nomenclador = $nomenclador;
	}
	
	public function getTipoAfiliado()
	{
	    if( $this->clienteObraSocial !=null )
	    return $this->clienteObraSocial->getTipoAfiliado();
	}

	public function setTipoAfiliado($tipo)
	{
	    if( $this->clienteObraSocial !=null )
	    $this->clienteObraSocial->setTipoAfiliado($tipo);
	}
	
	public function getClienteObraSocial()
	{
	    return $this->clienteObraSocial;
	}

	public function setClienteObraSocial($clienteObraSocial)
	{
	    $this->clienteObraSocial = $clienteObraSocial;
	}

	public function getObservaciones()
	{
	    return $this->observaciones;
	}

	public function setObservaciones($observaciones)
	{
	    $this->observaciones = $observaciones;
	}
	
	public function getPlanObraSocial()
	{
	    if( $this->clienteObraSocial !=null )
	    return $this->clienteObraSocial->getPlanObraSocial();
	}

	public function setPlanObraSocial($planObraSocial)
	{
		if($this->clienteObraSocial == null )
			$this->clienteObraSocial = new ClienteObraSocial();
	    $this->clienteObraSocial->setPlanObraSocial($planObraSocial);
	}
}
?>