<?php

namespace Turnos\Core\Test\obrasSociales;

include_once dirname(__DIR__). '/conf/init.php';

use Turnos\Core\Test\GenericTest;
use Cose\Security\service\SecurityContext;
use Turnos\Core\service\ServiceFactory;
use Turnos\Core\criteria\ObraSocialCriteria;

class ListObrasSocialesTest extends GenericTest{
	
	
	public function test(){

		
		$securityContext =  SecurityContext::getInstance();
		$securityContext->login( "oscar", "4");
		
		$service = ServiceFactory::getObraSocialService();
		
		\Logger::getLogger(__CLASS__)->info("listando obras sociales");		
		
		$criteria = new ObraSocialCriteria();
		
		$obras = $service->getList( $criteria );
		
		foreach ($obras as $os) {
			\Logger::getLogger(__CLASS__)->info("OS: " . $os->__toString());
		}
		
	}
}
?>