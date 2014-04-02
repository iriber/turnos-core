<?php
namespace Turnos\Core\model;

use Cose\model\impl\Entity;

use Turnos\Core\model\Cliente,
	Turnos\Core\model\ObraSocial,
	Turnos\Core\model\Nomenclador,
	Turnos\Core\model\Profesional;

/**
 * Practica
 *
 * @Entity @Table(name="trn_practica")
 *
 * @author Bernardo
 * @since 21-05-2013
 */
	
class Practica extends Entity {

	//variables de instancia.


	/** @Column(type="date") **/
	private $fecha;

	/**
	 * @ManyToOne(targetEntity="Cliente",cascade={"merge"})
     * @JoinColumn(name="cliente_oid", referencedColumnName="oid")
     * @var Cliente
	 */
	private $cliente;

	/**
     * @ManyToOne(targetEntity="Profesional",cascade={"merge"})
     * @JoinColumn(name="profesional_oid", referencedColumnName="oid")
     **/
	private $profesional;

	/** @Column(type="string") **/
	private $observaciones;

	/**
     * @ManyToOne(targetEntity="ClienteObraSocial",cascade={"persist"})
     * @JoinColumn(name="clienteObraSocial_oid", referencedColumnName="oid")
     **/
	private $clienteObraSocial;
		
	/**
     * @ManyToOne(targetEntity="Nomenclador",cascade={"merge"})
     * @JoinColumn(name="nomenclador_oid", referencedColumnName="oid")
     **/
	private $nomenclador;

	
	
	public function __construct(){
		 
		$this->profesional = new Profesional();
		$this->cliente = new Cliente();
		$this->clienteObraSocial = new ClienteObraSocial();
		$this->nomenclador = new Nomenclador();
		$this->observaciones = ""; 
	}


	public function __toString()
	{
		return $this->getFecha() . " - " . $this->getProfesional()->__toString(). " - " . $this->getCliente()->__toString() ;
	}



	public function getFecha()
	{
	    return $this->fecha;
	}

	public function setFecha($fecha)
	{
	    $this->fecha = $fecha;
	}

	public function getCliente()
	{
	    return $this->cliente;
	}

	public function setCliente($cliente)
	{
	    $this->cliente = $cliente;
	}

	public function getProfesional()
	{
	    return $this->profesional;
	}

	public function setProfesional($profesional)
	{
	    $this->profesional = $profesional;
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
			
		$this->clienteObraSocial->setObraSocial( $obraSocial );
	}

	public function getNomenclador()
	{
	    return $this->nomenclador;
	}

	public function setNomenclador($nomenclador)
	{
	    $this->nomenclador = $nomenclador;
	}

	public function getObservaciones()
	{
	    return $this->observaciones;
	}

	public function setObservaciones($observaciones)
	{
	    $this->observaciones = $observaciones;
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
	
	
	public function getTipoAfiliado()
	{
	    if( $this->clienteObraSocial !=null )
	    return $this->clienteObraSocial->getTipoAfiliado();
	}

	public function setTipoAfiliado($tipo)
	{
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
}
?>