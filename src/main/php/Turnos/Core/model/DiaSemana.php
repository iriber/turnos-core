<?php
namespace Turnos\Core\model;

/**
 * Dia de la semana 
 *  
 * @author Bernardo
 * @since 21-05-2013
 */

class DiaSemana {
    
    const Domingo = 0;
    const Lunes = 1;
    const Martes = 2;
    const Miercoles = 3;
    const Jueves = 4;
    const Viernes = 5;
    const Sabado= 6;
    
    
    private static $items= array( self::Domingo=> "dia.domingo.label", 
    								   self::Lunes=> "dia.lunes.label",
    								   self::Martes=> "dia.martes.label",
    								   self::Miercoles=> "dia.miercoles.label",
    								   self::Jueves=> "dia.jueves.label",
    								   self::Viernes=> "dia.viernes.label",
    								   self::Sabado => "dia.sabado.label");
    
	public static function getItems(){
		return self::$items;
	}
	
	public static function getLabel($value){
		return self::$items[$value];
	}
    
	public static function getDia(\Datetime $fecha){
		//$day_of_week es 1, si es lunes.
		//$value = str_replace('/', '-', $fecha);
		//$i = strtotime( $value );
		$i = $fecha->getTimestamp();
     	return jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m", $i), date("d", $i), date("Y", $i)), 0);    	
    }
    
    
}
?>
