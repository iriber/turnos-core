<?php
namespace Turnos\Core\model;

use Cose\model\impl\Entity;

use	Cose\Security\model\User;

use Turnos\Core\model\TipoDocumento,
	Turnos\Core\model\CondicionIVA,
	Turnos\Core\model\CategoriaProfesional,
	Turnos\Core\model\Profesional;

/**
 * Profesional
 *
 * @Entity @Table(name="trn_profesional")
 * 
 * @author Bernardo
 * @since 21-05-2013
 */	
class Profesional extends Entity {

	//variables de instancia.

	/** @Column(type="string") **/
	private $nombre;

	/** @Column(type="string", nullable=true) **/
	private $matricula;

	/** @Column(type="string", nullable=true) **/
	private $domicilio;

	/** @Column(type="string", nullable=true) **/
	private $nroDocumento;

	/**
	 * @Column(type="integer", nullable=true)
	 * @var TipoDocumento
	 */
	private $tipoDocumento;

	/** @Column(type="string", nullable=true) **/
	private $telefonoFijo;

	/** @Column(type="string", nullable=true) **/
	private $telefonoMovil;

	/** @Column(type="string", nullable=true) **/
	private $email;

	/** @Column(type="string", nullable=true) **/
    private $cuit;

    /**
     * @Column(type="integer", nullable=true)
     * @var CondicionIVA
     */
    private $condicionIVA;
	
    /**
     * @Column(type="integer", nullable=true)
     * @var CategoriaProfesional
     */
    private $categoria;
    
    /**
     * @ManyToOne(targetEntity="Cose\Security\model\User",cascade={"persist"})
     * @JoinColumn(name="user_oid", referencedColumnName="oid")
     **/
    private $user;
    
    /**
     * @ManyToMany(targetEntity="Especialidad")
     * @JoinTable(name="trn_profesional_especialidad",
     *      joinColumns={@JoinColumn(name="profesional_oid", referencedColumnName="oid")},
     *      inverseJoinColumns={@JoinColumn(name="especialidad_oid", referencedColumnName="oid")}
     *      )
     */
    private $especialidades;
    
	public function __construct(){
		 
		$this->tipoDocumento = TipoDocumento::DNI;
		$this->condicionIVA = CondicionIVA::ConsumidorFinal;
		$this->categoria = CategoriaProfesional::Basico;
		//$this->user = new User();
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
	
	public function getMatricula()
	{
		return $this->matricula;
	}

	public function setMatricula($matricula)
	{
		$this->matricula = $matricula;
	}
	

	public function getDomicilio()
	{
		return $this->domicilio;
	}

	public function setDomicilio($domicilio)
	{
		$this->domicilio = $domicilio;
	}

	public function getNroDocumento()
	{
		return $this->nroDocumento;
	}

	public function setNroDocumento($nroDocumento)
	{
		$this->nroDocumento = $nroDocumento;
	}

	public function getTipoDocumento()
	{
		return $this->tipoDocumento;
	}

	
	public function setTipoDocumento($tipoDocumento)
	{
		$this->tipoDocumento = $tipoDocumento;
	}

	public function setTipoDocumentoOid($oid)
	{
		$this->tipoDocumento->setOid($oid);
	}

	public function getTelefonoFijo()
	{
		return $this->telefonoFijo;
	}

	public function setTelefonoFijo($telefonoFijo)
	{
		$this->telefonoFijo = $telefonoFijo;
	}

	public function getTelefonoMovil()
	{
		return $this->telefonoMovil;
	}

	public function setTelefonoMovil($telefonoMovil)
	{
		$this->telefonoMovil = $telefonoMovil;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function setEmail($email)
	{
		$this->email = $email;
	}

	public function __toString()
	{
		return $this->getNombre();
	}

	public function getCuit()
    {
        return $this->cuit;
    }

    public function setCuit($cuit)
    {
        $this->cuit = $cuit;
    }

    public function getCondicionIVA()
    {
        return $this->condicionIVA;
    }

    public function getCondicionIVAOid()
    {
        return $this->condicionIVA->getOid();
    }
    
    public function setCondicionIVA($condicionIVA)
    {
        $this->condicionIVA = $condicionIVA;
    }

	public function setCondicionIVAOid($oid)
    {
        $this->condicionIVA->setOid($oid);
    }

	public function getCategoria()
	{
	    return $this->categoria;
	}

	public function setCategoria($categoria)
	{
	    $this->categoria = $categoria;
	}

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }
    
    public function addEspecialidad( Especialidad $especialidad ){
    	
    	$this->especialidades[] = $especialidad;
    }

	public function getEspecialidades()
	{
	    return $this->especialidades;
	}

	public function setEspecialidades($especialidades)
	{
	    $this->especialidades = $especialidades;
	}
	
	public function hasEspecialidadByOid($oid){
	
		$ok = false;
		
		if($this->getEspecialidades() == null )
			return false;
		
		foreach ($this->getEspecialidades() as $especialidad) {
			$ok = ($especialidad->getOid() == $oid);
			if( $ok )
				break;
		}
		
		return $ok;
		
	}
}
?>
