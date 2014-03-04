<?php

namespace Turnos\Core\Test\profesionales;



include_once dirname(__DIR__). '/conf/init.php';


use Turnos\Core\Test\GenericTest;
use Cose\Security\service\SecurityContext;
use Turnos\Core\service\ServiceFactory;
use Turnos\Core\model\Profesional;

use Cose\Security\model\User;

class AsignarEspecialidadesProfesionalTest extends GenericTest{
	
	
	public function test(){

		
		$securityContext =  SecurityContext::getInstance();
		$securityContext->login( "bernardo", "4");
		
		$service = ServiceFactory::getProfesionalService();
		
		\Logger::getLogger(__CLASS__)->info("asignando especialidades a Profesional");		
		
		$profesional = $service->get(24);
		
		$especialidadService = ServiceFactory::getEspecialidadService();
		
		$especialidades = array();
		$especialidades[] = $especialidadService->get(1);
		$especialidades[] = $especialidadService->get(2);
		$profesional->setEspecialidades( $especialidades );
		
		$service->update( $profesional );
	}
}
?>