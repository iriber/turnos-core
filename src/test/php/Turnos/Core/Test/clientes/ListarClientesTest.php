<?php

namespace Turnos\Core\Test\clientes;

include_once dirname(__DIR__). '/conf/init.php';

use Turnos\Core\Test\GenericTest;
use Cose\Security\service\SecurityContext;
use Turnos\Core\service\ServiceFactory;
use Turnos\Core\criteria\ClienteCriteria;

class ListClientesTest extends GenericTest{
	
	/**
	 * @Security( permission="listar_clientes" )
	 */
	public function test(){

		
		$securityContext =  SecurityContext::getInstance();
		$securityContext->login( "bernardo", "4");
		
		$service = ServiceFactory::getClienteService();
		
		$this->log("listando clientes", __CLASS__);
		
		$criteria = new ClienteCriteria();
		$criteria->setMaxResult(5);
		$criteria->setNombre("IRIBARNE FLORE");
		
		$clientes = $service->getList( $criteria );
		
		foreach ($clientes as $cliente) {
			
			$this->log("Cliente: " . $cliente, __CLASS__);
			
		}
		
	}
}
?>