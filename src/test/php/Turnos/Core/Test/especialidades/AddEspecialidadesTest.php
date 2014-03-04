<?php

namespace Turnos\Core\Test\especialidades;

use Turnos\Core\model\Especialidad;

include '../../conf/modules.php';

use Turnos\Core\Test\GenericTest;
use Cose\Security\service\SecurityContext;
use Turnos\Core\service\ServiceFactory;
use Turnos\Core\criteria\EspecialidadCriteria;

include_once dirname(__DIR__). '/conf/init.php';

class AddEspecialidadesTest extends GenericTest{
	
	
	public function test(){

		
		$securityContext =  SecurityContext::getInstance();
		$securityContext->login( "bernardo", "4");
		
		$service = ServiceFactory::getEspecialidadService();
		
		\Logger::getLogger(__CLASS__)->info("agregando Especialidad");		
		
		$especialidad = new Especialidad();
		$especialidad->setNombre("DEPORTOLOGÍA");
		$service->add( $especialidad );
		
		
	}
}
?>