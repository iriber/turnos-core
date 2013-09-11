<?php

namespace Turnos\Core\Test\profesionales;

include_once dirname(__DIR__). '/conf/init.php';

use Turnos\Core\Test\GenericTest;
use Cose\Security\service\SecurityContext;
use Turnos\Core\service\ServiceFactory;
use Turnos\Core\criteria\ProfesionalCriteria;

class ListProfesionalesTest extends GenericTest{
	
	
	public function test(){

				
		$securityContext =  SecurityContext::getInstance();
		$securityContext->login( "bernardo", "4");
		
		$service = ServiceFactory::getProfesionalService();
		
		\Logger::getLogger(__CLASS__)->info("listando Profesionales");		
		
		$criteria = new ProfesionalCriteria();
		$criteria->setNombre("Bernardo");
		
		$profesionales = $service->getList( $criteria );
		
		foreach ($profesionales as $profesional) {
			\Logger::getLogger(__CLASS__)->info("Nombre: " . $profesional->getNombre());
		}
		
	}
}
?>