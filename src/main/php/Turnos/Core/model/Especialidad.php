<?php

namespace Turnos\Core\model;

use Cose\model\impl\Entity;

use Turnos\Core\model\Profesional;

/**
 * Especialidad
 * 
 * @Entity @Table(name="trn_especialidad")
 * 
 * @author Bernardo
 * @since 26-02-2014
 */

class Especialidad extends Entity{

	//variables de instancia.

	/**
	 * @Column(type="string")
	 * @var unknown_type
	 */
	private $nombre;

	/** @Column(type="string") **/
	private $descripcion;



	public function __construct(){
	}
	
	public function __toString(){
		return $this->getNombre();
	}


	public function getNombre()
	{
	    return $this->nombre;
	}

	public function setNombre($nombre)
	{
	    $this->nombre = $nombre;
	}

	public function getDescripcion()
	{
	    return $this->descripcion;
	}

	public function setDescripcion($descripcion)
	{
	    $this->descripcion = $descripcion;
	}
}
?>
