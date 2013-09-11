<?php

namespace Turnos\Core\model;
/**
 * Estado de turno 
 *  
 * @author Bernardo
 * @since 21-05-2013
 */

class EstadoTurno {
    
    const EnSala = 1;
    const Atendido = 2;
    /*const Cancelado = 3;*/
    const Asignado = 4;
	const EnCurso= 5;
    const EnSalaImportante= 6;
    const EnSalaUrgente= 7;
    
    private static $items = array(  
    								   EstadoTurno::Asignado => "turno.asignado.label",
    								   EstadoTurno::EnSala=> "turno.ensala.label",
    								   EstadoTurno::Atendido => "turno.atendido.label",
    								   //EstadoTurno::Cancelado => TRN_MSG_ESTADO_TURNO_CANCELADO,
    								   EstadoTurno::EnCurso=> "turno.encurso.label"
    								   );

    private static $abreviados = array(  
    								   EstadoTurno::Asignado => "turno.asignado.abreviado.label",
    								   EstadoTurno::EnSala=> "turno.ensala.abreviado.label",
    								   EstadoTurno::Atendido => "turno.atendido.abreviado.label",
    								   //EstadoTurno::Cancelado => TRN_MSG_ESTADO_TURNO_CANCELADO,
    								   EstadoTurno::EnCurso=> "turno.encurso.abreviado.label"
        								   );

        								   /*
	private static $colores = array(  
    								   EstadoTurno::Asignado => "#0000FF",
    								   EstadoTurno::EnSala=> "#00FF00",
    								   EstadoTurno::Atendido => "#FF0000",
    								   //EstadoTurno::Cancelado => "#FFFFFF",
    								   EstadoTurno::EnCurso => "#00FF00"
    								   );*/
    								   
	
	public static function getItems(){
		return self::$items;
	}
	
	public static function getLabel($value){
		return self::$items[$value];
	}

	public static function getLabelAbreviado($value){
		return self::$abreviados[$value];
	}

	/*
	public static function getColor($value){
		return self::$colores[$value];
	}*/
}
?>
