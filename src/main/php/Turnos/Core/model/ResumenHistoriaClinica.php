<?php
namespace Turnos\Core\model;

use Cose\model\impl\Entity;

use Turnos\Core\model\Cliente,
	Turnos\Core\model\Profesional;

/**
 * Resumen de historia clínica armada
 * manualmente por el profesional
 *
 * @Entity @Table(name="trn_resumen_historia_clinica")
 * 
 * @author Bernardo
 * @since 08-07-2013
 */

class ResumenHistoriaClinica extends Entity {

	//variables de instancia.

	/**
	 * @Column(type="string")
	 * @var string
	 */
	private $fecha;

	/**
     * @ManyToOne(targetEntity="Cliente",cascade={"none"})
     * @JoinColumn(name="cliente_oid", referencedColumnName="oid")
     * @var Cliente
     **/
	private $cliente;

	/**
     * @ManyToOne(targetEntity="Profesional",cascade={"none"})
     * @JoinColumn(name="profesional_oid", referencedColumnName="oid")
     * @var Profesional
     **/
	private $profesional;

	/**
	 * @Column(type="string")
	 * @var string
	 */
	private $texto;

	
	public function __construct(){
		 
		$this->profesional = new Profesional();
		$this->cliente = new Cliente();
		$this->texto = ""; 
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

	public function getTexto()
	{
	    return $this->texto;
	}

	public function setTexto($texto)
	{
	    $this->texto = $texto;
	}
}
?>