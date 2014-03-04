<?php

namespace Turnos\Core\model;
/**
 * Prioridades para los turnos 
 *  
 * @author Bernardo
 * @since 25-02-2014
 */

class Prioridad {
    
    const Normal = 1;
    const Media = 2;
    const Alta = 3;
    
    private static $items = array(  
    								   Prioridad::Normal => "prioridad.normal.label",
    								   Prioridad::Media=> "prioridad.media.label",
    								   Prioridad::Alta=> "prioridad.alta.label"
    								   );

    private static $abreviados = array(  
    								   Prioridad::Normal => "prioridad.normal.abreviado.label",
    								   Prioridad::Media=> "prioridad.media.abreviado.label",
    								   Prioridad::Alta=> "prioridad.alta.abreviado.label"
        								   );
    								   
	
	public static function getItems(){
		return self::$items;
	}
	
	public static function getLabel($value){
		return self::$items[$value];
	}

	public static function getLabelAbreviado($value){
		return self::$abreviados[$value];
	}

}
?>