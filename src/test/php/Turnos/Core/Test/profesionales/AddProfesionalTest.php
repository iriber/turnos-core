<?php

namespace Turnos\Core\Test\profesionales;



include_once dirname(__DIR__). '/conf/init.php';


use Turnos\Core\Test\GenericTest;
use Cose\Security\service\SecurityContext;
use Turnos\Core\service\ServiceFactory;
use Turnos\Core\model\Profesional;

use Cose\Security\model\User;

class AddProfesionalTest extends GenericTest{
	
	
	public function test(){

		
		$securityContext =  SecurityContext::getInstance();
		$securityContext->login( "iriber", "123456");
		
		$service = ServiceFactory::getProfesionalService();
		
		\Logger::getLogger(__CLASS__)->info("agregando Profesional");		
		
		$profesional = new Profesional();
		$profesional->setNombre("Pedro");
		$profesional->setMatricula("123456");
		$user = new User();
		$user->setUsername("bernardo");
		$user->setPassword("4");
		$profesional->setUser($user);
		$service->add( $profesional );
		
		
	}
}
?>