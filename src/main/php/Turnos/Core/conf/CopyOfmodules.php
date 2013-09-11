<?php

/**
 * se configuran los módulos para la app.
 * 
 * @author bernardo
 * @since 
 * 
 */

//setlocale(LC_ALL, 'Portuguese_Portugal.1252');
setlocale(LC_ALL, "es_AR.UTF-8");

//definimos la constante CDT_HOME apuntando al directorio que 
//contendrá los módulos de COSE.
define( "CDT_HOME", "/home/bernardo/workspace_php/codnet_fmk" );

//definimos la constante que apunta al módulo de servicios.
define( "CDT_SERVICES_HOME", CDT_HOME . "/Cose" );

//definimos la constante que apunta al módulo crud.
define( "COSE_CRUD_HOME", CDT_HOME . "/Cose\Crud" );

//definimos la constante que apunta al módulo security.
define( "COSE_SECURITY_HOME", CDT_HOME . "/Cose\Security" );

//definimos el home de nuestra app y el nombre con el cual accederemos
//desde la web.	
define( "APP_HOME", CDT_HOME . "/Turnos\Core" );
define( "APP_NAME", "turnos_core" );


//definimos la ubicación del archivo de configuración para log4php
define( "CDT_LOG4PHP_CONFIG_FILE", APP_HOME . "/conf/log4php.xml", true) ;


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

