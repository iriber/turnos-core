<?php
namespace Turnos\Core\model;

use Cose\model\impl\Entity;

/**
 * Nomenclador
 *
 * @Entity @Table(name="trn_nomenclador")
 * 
 * @author Bernardo
 * @since 23-05-2013
 */
class Nomenclador extends Entity {

	//variables de instancia.

	/** @Column(type="string") **/
	private $codigo;

	/** @Column(type="string") **/
	private $nombre;

	

	public function getCodigo()
	{
	    return $this->codigo;
	}

	public function setCodigo($codigo)
	{
	    $this->codigo = $codigo;
	}

	public function getNombre()
	{
	    return $this->nombre;
	}

	public function setNombre($nombre)
	{
	    $this->nombre = $nombre;
	}
	
	public function __toString(){
		return $this->getNombre();
	}
}
?>