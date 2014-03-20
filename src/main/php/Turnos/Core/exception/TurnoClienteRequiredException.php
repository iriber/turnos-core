<?php

namespace Turnos\Core\exception;

use Cose\exception\ServiceException;

/**
 * Excepción para indicar que se requiere indicar un cliente
 * en el turno
 * 
 * @author bernardo
 * @since 20-03-2014
 */

class TurnoClienteRequiredException extends ServiceException{
	
	private $turno;
	
	public function __construct($msg="turno.cliente.required"){

		parent::__construct($msg);
		
	}
	

	public function getTurno()
	{
	    return $this->turno;
	}

	public function setTurno($turno)
	{
	    $this->turno = $turno;
	}
}
