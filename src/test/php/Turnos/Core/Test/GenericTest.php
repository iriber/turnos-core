<?php

namespace Turnos\Core\Test;



use Cose\utils\Logger;
use Turnos\Core\conf\TurnosConfig;
use Cose\persistence\PersistenceContext;

class GenericTest extends \PHPUnit_Framework_TestCase{
	
	/**
	 * 
	 * @var \Cose\persistence\PersistenceContext
	 */
	protected $persistenceContext;
	
	protected function setUp() {

		//inicializamos turnos core.
		TurnosConfig::getInstance()->initialize();
		TurnosConfig::getInstance()->initLogger(dirname(__DIR__) . "/Test/conf/log4php.xml");
				
		$this->persistenceContext =  PersistenceContext::getInstance();
		
	}
	
	protected function tearDown() {

		$this->log("successful!", __CLASS__);
		
        //cerramos la conexión a la base.
        $this->persistenceContext->close();
    }
    
    protected function log($msg, $clazz=__CLASS__){
    	Logger::log($msg, $clazz);
    }
    
}
?>