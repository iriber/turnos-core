<?php

namespace Turnos\Core\model;

use Cose\model\impl\Entity;

use Turnos\Core\model\TipoDocumento,
	Turnos\Core\model\ObraSocial,
	Turnos\Core\model\Localidad;

/**
 * Info de obra social para Cliente
 * 
 * @Entity @Table(name="trn_cliente_obra_social")
 * 
 * @author Bernardo
 * @since 01-04-2014
 */
	
class ClienteObraSocial extends Entity {

	//variables de instancia.

	/**
     * @ManyToOne(targetEntity="ObraSocial",cascade={"merge"})
     * @JoinColumn(name="obraSocial_oid", referencedColumnName="oid")
     **/
	private $obraSocial;

	/**
     * @ManyToOne(targetEntity="Cliente",cascade={"merge"}, fetch="LAZY")
     * @JoinColumn(name="cliente_oid", referencedColumnName="oid")
     * @var Cliente
     **/
	private $cliente;
	
	/** 
	 * @Column(type="string", nullable=true)
	 *  
	 **/
	private $nroObraSocial;


	/** 
	 * @Column(type="integer")
	 * var TipoAfiliadoObraSocial 
	 **/
	private $tipoAfiliado;

	//TODO plan?		
	
	
	public function __construct(){

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

	public function getTipoAfiliado()
	{
	    return $this->tipoAfiliado;
	}

	public function setTipoAfiliado($tipoAfiliado)
	{
	    $this->tipoAfiliado = $tipoAfiliado;
	}

	public function getCliente()
	{
	    return $this->cliente;
	}

	public function setCliente($cliente)
	{
	    $this->cliente = $cliente;
	}
}