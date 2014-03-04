<?php

namespace Turnos\Core\Test\profesionales;

include_once dirname(__DIR__). '/conf/init.php';

use Turnos\Core\Test\GenericTest;
use Cose\Security\service\SecurityContext;
use Turnos\Core\service\ServiceFactory;
use Turnos\Core\criteria\ProfesionalCriteria;

class ListProfesionalesByEspecialidadTest extends GenericTest{
	
	
	public function test(){

				
		$securityContext =  SecurityContext::getInstance();
		$securityContext->login( "bernardo", "4");
		
		$service = ServiceFactory::getProfesionalService();
		
		\Logger::getLogger(__CLASS__)->info("listando Profesionales por Especialidad");		
		
		$especialidadService = ServiceFactory::getEspecialidadService();
		$especialidad = $especialidadService->get(1);
		
		$profesionales = $service->getProfesionalesByEspecialidad( $especialidad );
		
		foreach ($profesionales as $profesional) {
			\Logger::getLogger(__CLASS__)->info("Nombre: " . $profesional->getNombre());
		}
		
	}
}
?>