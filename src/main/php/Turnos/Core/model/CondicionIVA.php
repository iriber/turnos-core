<?php
/**
 * Condición frente al iva 
 *  
 * @author Bernardo
 * @since 21-05-2013
 */

namespace Turnos\Core\model;


class CondicionIVA   {
    
    
    const ResponsableInscripto = 1;
    const ResponsableNoInscripto = 2;
    const ResponsableMonotributo = 3;
    const Exento = 4;
	const ConsumidorFinal = 5;

	private static $items = array( self::ResponsableInscripto=> "iva.ri.label", 
    								   self::ResponsableMonotributo=> "iva.m.label",
    								   self::ResponsableNoInscripto=> "iva.rni.label",
    								   self::Exento=> "iva.e.label",
    								   self::ConsumidorFinal=> "iva.cf.label");
    
	public static function getItems(){
		return self::$items;
	}
	
	public static function getLabel($value){
		return self::$items[$value];
	}
}
?>
