<?php
namespace Turnos\Core\model;

use Cose\model\impl\Entity;

/**
 * Obra social
 * 
 * @Entity @Table(name="trn_obra_social")
 * 
 * @author Bernardo
 * @since 21-05-2013
 */
class ObraSocial extends Entity{

	//variables de instancia.

	/** 
	 * 
	 * @Column(type="string") 
	 * 
	 **/
	private $nombre;

	/** @Column(type="string") **/
	private $codigo;

	/** @Column(type="string") **/
	private $cuit;
	
	/** @Column(type="string") **/
	private $domicilio;
	
	/** @Column(type="string") **/
	private $circulo;
	
	public function __construct(){
		$this->nombre = "";
	}
	
	public function getNombre()
	{
		return $this->nombre;
	}

	public function setNombre($nombre)
	{
		$this->nombre = $nombre;
	}

	public function getCodigo()
	{
		return $this->codigo;
	}

	public function setCodigo($codigo)
	{
		$this->codigo = $codigo;
	}
/*
	public function __toString(){
		return $this->getNombre();
	}*/

	public function getCuit()
	{
	    return $this->cuit;
	}

	public function setCuit($cuit)
	{
	    $this->cuit = $cuit;
	}

	public function getDomicilio()
	{
	    return $this->domicilio;
	}

	public function setDomicilio($domicilio)
	{
	    $this->domicilio = $domicilio;
	}

	public function getCirculo()
	{
	    return $this->circulo;
	}

	public function setCirculo($circulo)
	{
	    $this->circulo = $circulo;
	}
}
?>
