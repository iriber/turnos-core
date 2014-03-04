<?php

/**
 * se configuran los módulos para la app.
 * 
 * @author bernardo
 * @since 
 * 
 */

use Cose\conf\CoseConfig; 

//setlocale(LC_ALL, 'Portuguese_Portugal.1252');
setlocale(LC_ALL, "es_AR.UTF-8");

//definimos la constante CDT_HOME apuntando al directorio que 
//contendrá los módulos de COSE.
define( "CDT_HOME", "/home/bernardo/workspace_php/codnet_fmk/" );

//definimos el home de nuestra app y el nombre con el cual accederemos
//desde la web.	
define( "APP_NAME", "turnos_core" );

define( "APP_HOME", "/home/bernardo/workspace_php/turnos_core/" );

//definimos la ubicación del archivo de configuración para log4php
define( "CDT_LOG4PHP_CONFIG_FILE", APP_HOME . "/conf/log4php.xml", true) ;


require APP_HOME . 'vendor/autoload.php';


//se inicializan los módulos básicos .
CoseConfig::initialize(APP_HOME, CDT_HOME);

//especificamos los paths donde se encuentran los modelos para el mapeo.
Cose\conf\CoseConfig::initializeEntitiesClasspath( 
			array( //CDT_HOME . "Cose/model",
					//CDT_HOME . "Cose\Security/model",
				   APP_HOME. "/model"	) );
				   
				   
/*
//inicializamos los módulos de COSE y el classloader.	
if (!class_exists("Cose\conf\CoseSetup", false)) {

	require_once CDT_SERVICES_HOME . "/conf/CoseSetup.php";
		
	//se inicializan los módulos básicos .
	Cose\conf\CoseSetup::initBasicModules();

	//se inicializa el classloader para Cose\Crud.
	Cose\conf\CoseSetup::registerAutoloadDirectory("Cose\Crud", CDT_HOME);
	
	//se inicializa el classloader para Cose\Security.
	Cose\conf\CoseSetup::registerAutoloadDirectory("Cose\Security", CDT_HOME);
	
	//se inicializa el classloader para nuestra app.
	//debemos indicar el namespace root de nuestra app.
	Cose\conf\CoseSetup::registerAutoloadDirectory("Turnos\Core", CDT_HOME);

	//especificamos los paths donde se encuentran los modelos para el mapeo.
	Cose\conf\CoseSetup::initializeEntitiesClasspath( 
			array( CDT_SERVICES_HOME . "/model",
					COSE_SECURITY_HOME . "/model",
				   APP_HOME. "/model"	) );
}

*/
