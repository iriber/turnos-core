<?php

namespace Turnos\Core\Test\especialidades;

include_once dirname(__DIR__). '/conf/init.php';

use Turnos\Core\Test\GenericTest;
use Cose\Security\service\SecurityContext;
use Turnos\Core\service\ServiceFactory;
use Turnos\Core\criteria\EspecialidadCriteria;

class ListEspecialidadesTest extends GenericTest{
	
	/**
	 * @Security( permission="listar_especialidades" )
	 */
	public function test(){

		
		$securityContext =  SecurityContext::getInstance();
		$securityContext->login( "bernardo", "4");
		
		$service = ServiceFactory::getEspecialidadService();
		
		$this->log("listando Especialidades", __CLASS__);
		
		$criteria = new EspecialidadCriteria();
		$criteria->setMaxResult(5);
		//$criteria->setNombre("IRIBARNE FLORE");
		
		$especialidades = $service->getList( $criteria );
		
		foreach ($especialidades as $especialidad) {
			
			$this->log("Especialidad: " . $especialidad, __CLASS__);
			
		}
		
	}
}
?>