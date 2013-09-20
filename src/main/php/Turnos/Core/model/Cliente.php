<?php

namespace Turnos\Core\model;

use Cose\model\impl\Entity;

use Turnos\Core\model\TipoDocumento,
	Turnos\Core\model\ObraSocial,
	Turnos\Core\model\Localidad;

/**
 * Cliente
 * 
 * @Entity @Table(name="trn_cliente")
 * 
 * @author Bernardo
 * @since 21-05-2013
 */
	
class Cliente extends Entity {

	//variables de instancia.

	/** 
	 * @Column(type="string", nullable=true)
	 *  
	 **/
	private $nombre;

	/** 
	 * @Column(type="string") 
	 **/
	private $apellido;

	/** 
	 * @Column(type="string", nullable=true)
	 *  
	 **/
	private $domicilio;

	/** 
	 * @Column(type="string", nullable=true)
	 *  
	 **/
	private $nroDocumento;

	/**
	 * @Column(type="integer", nullable=true)
	 * @var unknown_type
	 */
	private $tipoDocumento;

	/** 
	 * @Column(type="string", nullable=true)
	 *  
	 **/
	private $telefonoFijo;

	/** 
	 * @Column(type="string", nullable=true)
	 *  
	 **/
	private $telefonoMovil;

	/** 
	 * @Column(type="string", nullable=true)
	 *  
	 **/
	private $email;

	/**
	 * @Column(type="integer", nullable=true)
	 * @var unknown_type
	 */
	private $sexo;
	
	/**
     * @ManyToOne(targetEntity="ObraSocial",cascade={"merge"})
     * @JoinColumn(name="obraSocial_oid", referencedColumnName="oid")
     **/
	private $obraSocial;

	/** 
	 * @Column(type="string", nullable=true)
	 *  
	 **/
	private $nroObraSocial;
	
	/**
     * @ManyToOne(targetEntity="Localidad",cascade={"merge"})
     * @JoinColumn(name="localidad_oid", referencedColumnName="oid")
     **/
	private $localidad;
	 
	/** 
	 * @Column(type="date", nullable=true)
	 *  
	 **/
	private $fechaNacimiento;
	
	/** 
	 * @Column(type="date") 
	 **/
	private $fechaAlta;

	/**
	 * @Column(type="string", nullable=true)
	 */
	private $observaciones;
	
	/** 
	 * @Column(type="string", nullable=true)
	 *  
	 **/
	private $nroHistoriaClinica;
	
	
	public function __construct(){

		$this->setFechaAlta(new \DateTime(date('Y-m-d')));
		
		$this->tipoDocumento = TipoDocumento::DNI;
		$this->sexo = Sexo::MASCULINO;
		//$this->obraSocial = new ObraSocial();
		//$this->localidad = new Localidad();
			
	}


	public function getNombre()
	{
		return $this->nombre;
	}

	public function setNombre($nombre)
	{
		$this->nombre = $nombre;
	}

	public function getApellido()
	{
		return $this->apellido;
	}

	public function setApellido($apellido)
	{
		$this->apellido = $apellido;
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

	public function getTipoDocumentoOid()
	{
		return $this->tipoDocumento->getOid();
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
			
			$a = ( !empty($this->apellido) )?$this->apellido:"";
			$n = ( !empty($this->nombre) )?$this->nombre:"";
		
			return trim("$a $n" );
				
		
	}


	public function getSexo()
	{
	    return $this->sexo;
	}

	public function setSexo($sexo)
	{
	    $this->sexo = $sexo;
	}

	public function getObraSocial()
	{
	    return $this->obraSocial;
	}

	public function setObraSocial($obraSocial)
	{
	    $this->obraSocial = $obraSocial;
	}

	public function getFechaNacimiento()
	{
	    return $this->fechaNacimiento;
	}

	public function getFechaNacimientoFormateada()
	{
		if( !empty($this->fechaNacimiento) )
	    return $this->fechaNacimiento->format("d/m/Y");
	}
	
	public function setFechaNacimiento($fechaNacimiento)
	{
	    $this->fechaNacimiento = $fechaNacimiento;
	}

	public function getLocalidad()
	{
	    return $this->localidad;
	}

	public function setLocalidad($localidad)
	{
	    $this->localidad = $localidad;
	}

	public function getNroObraSocial()
	{
	    return $this->nroObraSocial;
	}

	public function setNroObraSocial($nroObraSocial)
	{
	    $this->nroObraSocial = $nroObraSocial;
	}

	public function getFechaAlta()
	{
	    return $this->fechaAlta;
	}

	public function getFechaAltaFormateada()
	{
		if( !empty($this->fechaAlta) )
	    return $this->fechaAlta->format("d/m/Y");
	}

	public function setFechaAlta($fechaAlta)
	{
	    $this->fechaAlta = $fechaAlta;
	}

	public function getNroHistoriaClinica()
	{
	    return $this->nroHistoriaClinica;
	}

	public function setNroHistoriaClinica($nroHistoriaClinica)
	{
	    $this->nroHistoriaClinica = $nroHistoriaClinica;
	}

	public function getEdad(){
		
		$fechaNac = $this->getFechaNacimiento();
		
		if ($fechaNac != null ){
			
			$hoy = new \DateTime();
			
			$dia = $hoy->format("d");
			$mes = $hoy->format("m");
			$anio = $hoy->format("Y");
			 
			//fecha de nacimiento
			$dia_nac = $fechaNac->format("d");
			$mes_nac = $fechaNac->format("m");
			$anio_nac = $fechaNac->format("Y");
			
			//si el mes es el mismo pero el día inferior aun no ha cumplido años, le quitaremos un año al actual
			 
			if (($mes_nac == $mes) && ($dia_nac > $dia)) {
				$anio=($anio-1); 
			}
			 
			//si el mes es superior al actual tampoco habrá cumplido años, por eso le quitamos un año al actual
			 
			if ($mes_nac > $mes) {
				$anio=($anio-1);
			}
			 
			//ya no habría mas condiciones, ahora simplemente restamos los años y mostramos el resultado como su edad
			 
			$edad=($anio-$anio_nac);    	    
				
		}
		else
			$edad = "";
		
    	return $edad;
	}

	public function getObservaciones()
	{
	    return $this->observaciones;
	}

	public function setObservaciones($observaciones)
	{
	    $this->observaciones = $observaciones;
	}
}