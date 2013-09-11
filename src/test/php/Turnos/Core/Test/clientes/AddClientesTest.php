<?php

namespace Turnos\Core\Test\clientes;

use Turnos\Core\model\Cliente;

include '../../conf/modules.php';

use Turnos\Core\Test\GenericTest;
use Cose\Security\service\SecurityContext;
use Turnos\Core\service\ServiceFactory;
use Turnos\Core\criteria\ClienteCriteria;

include_once dirname(__DIR__). '/conf/init.php';

class AddClientesTest extends GenericTest{
	
	
	public function test(){

		
		$securityContext =  SecurityContext::getInstance();
		$securityContext->login( "bernardo", "4");
		
		$service = ServiceFactory::getClienteService();
		
		\Logger::getLogger(__CLASS__)->info("agregando cliente");		
		
		$cliente = new Cliente();
		$cliente->setNombre("IRIBARNE FLORENCIA");
		$fecha = new \Datetime();
		//$fecha->setDate( 1981, 3, 17);
		//$cliente->setNroDocumento("28070832");
		$service->add( $cliente );
		
		
	}
}
?>