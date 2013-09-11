<?php
/**
 * se definen la configuración para la persistencia.
 * 
 * @author bernardo
 * @since 
 * 
 */

/*
 * valores para la unidad de persistencia por default
 * 
 * defaultUnit
 */
define('CDT_PERSISTENCE_DEFAULT_UNIT', 'defaultUnit');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root01');
//define('DB_NAME', 'turnos_core');
define('DB_NAME', 'instituto_access');

$pathEntities = CDT_ENTITIES_PATH ;
$namespaceProxies = "Doctrine\\Proxies";
$pathProxies =  CDT_HOME . "/vendors/Doctrine/Proxies";
//$namespaceProxies = CDT_HOME . "/Proxies";
//$pathProxies = 'CdtServices\Proxies';


$connectionOptions = array(
				    'driver'   => 'pdo_mysql',
				    'host'     => DB_HOST,
				    'dbname'   => DB_NAME,
				    'user'     => DB_USER,
				    'password' => DB_PASSWORD,
					'charset' => 'utf8',
                	'driverOptions' => array(
                    	    1002=>'SET NAMES utf8'
                	)
				);
Cose\persistence\PersistenceConfig::configure(CDT_PERSISTENCE_DEFAULT_UNIT, $namespaceProxies, $pathProxies, $pathEntities, $connectionOptions);

?>