<?php
namespace Turnos\Core\model;

/**
 * TipoAfiliadoObraSocial 
 *  
 * @author Bernardo
 * @since 27-05-2013
 */

class TipoAfiliadoObraSocial{
    
    const OBLIGATORIO = 1;
	const VOLUNTARIO = 2;
    
    
    private static $items = array(  
    								   self::OBLIGATORIO=> "tipoAfiliado.obligatorio.label",
    								   self::VOLUNTARIO=> "tipoAfiliado.voluntario.label"
    								   );
    
	public static function getItems(){
		return self::$items;
	}
	
	public static function getLabel($value){
		if(array_key_exists($value, self::$items))
		return self::$items[$value];
		else "";
	}
					   
}
?>
