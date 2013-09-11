<?php

namespace Turnos\Core\Test\nomenclador;

include_once dirname(__DIR__). '/conf/init.php';

use Turnos\Core\Test\GenericTest;
use Cose\Security\service\SecurityContext;
use Turnos\Core\service\ServiceFactory;
use Turnos\Core\criteria\NomencladorCriteria;

class GetNomencladorTest extends GenericTest{
	
	
	public function test(){

		
		$securityContext =  SecurityContext::getInstance();
		$securityContext->login( "bernardo", "4");
		
		$service = ServiceFactory::getNomencladorService();
		
		$codigo = "01.01.01";
		
		\Logger::getLogger(__CLASS__)->info("obteniendo nomenclador $codigo");		
		
		$criteria = new NomencladorCriteria();
		$criteria->setCodigo($codigo);
		
		$nomen = $service->getSingleResult( $criteria );
		
		\Logger::getLogger(__CLASS__)->info("Nomenclador: " . $nomen->__toString());
		
	}
}
?>