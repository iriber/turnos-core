<?php
namespace Turnos\Core\model;

use Cose\model\impl\Entity;

/**
 * Representa un plan de Obra Social
 * 
 * Ej: Osde 210, Osde 310, Medifé Plata, etc
 *
 * @Entity @Table(name="trn_plan_obra_social")
 * 
 * @author Bernardo
 * @since 24-04-2014
 */
class PlanObraSocial extends Entity {

	//variables de instancia.

	/**
	 * @Column(type="string")
	 * @var string
	 */
	private $nombre;

	/**
     * @ManyToOne(targetEntity="ObraSocial",cascade={"merge"})
     * @JoinColumn(name="obraSocial_oid", referencedColumnName="oid")
     **/
	private $obraSocial;
	

	public function __construct(){
		 
		$this->obraSocial = null; 
		
	}

	
	public function __toString(){
		return $this->getNombre();
	}


	public function getObraSocial()
	{
	    return $this->obraSocial;
	}

	public function setObraSocial($obraSocial)
	{
	    $this->obraSocial = $obraSocial;
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