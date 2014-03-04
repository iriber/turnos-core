<?php
namespace Turnos\Core\model;

use Cose\model\impl\Entity;

/**
 * Representa la relación entra un Nomenclador y una Obra Social
 * 
 * Podremos fijar el precio de una práctica para una obra social
 *
 * @Entity @Table(name="trn_obra_social_nomenclador")
 * 
 * @author Bernardo
 * @since 20-02-2014
 */
class ObraSocialNomenclador extends Entity {

	//variables de instancia.

	/**
	 * @Column(type="float", nullable=true)
	 * @var float
	 */
	private $importe;

	/**
	 * @Column(type="date")
	 * @var \DateTime
	 */
	private $fechaVigencia;

	/**
     * @ManyToOne(targetEntity="ObraSocial",cascade={"merge"})
     * @JoinColumn(name="obraSocial_oid", referencedColumnName="oid")
     **/
	private $obraSocial;
	
	/**
     * @ManyToOne(targetEntity="Nomenclador",cascade={"merge"})
     * @JoinColumn(name="nomenclador_oid", referencedColumnName="oid")
     **/
	private $nomenclador;
	


	public function __construct(){
		 
		$this->obraSocial = null; 
		$this->nomenclador = null;
		
	}

	
	public function __toString(){
		return $this->getObraSocial()->__toString() . " " . $this->getNomenclador()->__toString() . " " . $this->getImporte();
	}

	public function getImporte()
	{
	    return $this->importe;
	}

	public function setImporte($importe)
	{
	    $this->importe = $importe;
	}

	public function getFechaVigencia()
	{
	    return $this->fechaVigencia;
	}

	public function setFechaVigencia($fechaVigencia)
	{
	    $this->fechaVigencia = $fechaVigencia;
	}

	public function getObraSocial()
	{
	    return $this->obraSocial;
	}

	public function setObraSocial($obraSocial)
	{
	    $this->obraSocial = $obraSocial;
	}

	public function getNomenclador()
	{
	    return $this->nomenclador;
	}

	public function setNomenclador($nomenclador)
	{
	    $this->nomenclador = $nomenclador;
	}
}
?>