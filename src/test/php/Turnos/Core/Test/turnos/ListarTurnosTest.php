<?php

namespace Turnos\Core\Test\turnos;

include_once dirname(__DIR__). '/conf/init.php';

use Turnos\Core\model\Profesional;

include '../../conf/modules.php';

use Turnos\Core\Test\GenericTest;
use Cose\Security\service\SecurityContext;
use Turnos\Core\service\ServiceFactory;
use Turnos\Core\criteria\ProfesionalCriteria;

use Cose\utils\Logger;

class ListTurnosTest extends GenericTest{
	
	
	public function test(){

		
		$securityContext =  SecurityContext::getInstance();
		$securityContext->login( "oscar", "4");
		
		$service = ServiceFactory::getTurnoService();
		
		Logger::log( "listando Turnos" );		
		
		$profesional = new Profesional();
		$profesional->setOid(19);
		
		$fecha = new \DateTime();
		$fecha->setDate(2013,1, 7);
		
		$turnos = $service->getTurnosDelDia($fecha, $profesional);
		
		foreach ($turnos as $turno) {
			Logger::log("Turno: " . $turno );	
			
		}
		Logger::log("fin listando Turnos");		
	}
}
?>