<?php

namespace Turnos\Core\model;

/**
 * Categoría de un profesional 
 *  
 * @author Bernardo
 * @since 23-05-2013
 */

class CategoriaProfesional   {
    
    
    const Basico = 1;
    const Diferenciado = 2;

	private static $items = array( self::Basico=> "categoria.basico.label", 
    								   self::Diferenciado=> "categoria.diferenciado.label");
    
	public static function getItems(){
		return self::$items;
	}
	
	public static function getLabel($value){
		return self::$items[$value];
	}
}
?>
