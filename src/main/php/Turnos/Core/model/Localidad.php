<?php
namespace Turnos\Core\model;

use Cose\model\impl\Entity;

/**
 * Localidad 
 *  
 * @Entity @Table(name="trn_localidad")
 * 
 * @author Bernardo
 * @since 27-02-2013
 */

class Localidad extends Entity{

    //variables de instancia.

	/** @Column(type="string") **/
	private $nombre;
    

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
  
    public function __toString(){
    	return $this->getNombre();
    }
    
}
?>