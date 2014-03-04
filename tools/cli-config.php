<?php

//include_once '../conf/init.php';
include_once   dirname(__DIR__). '/vendor/autoload.php';

$classLoader = new \Doctrine\Common\ClassLoader('Entities', __DIR__);
$classLoader->register();

$classLoader = new \Doctrine\Common\ClassLoader('Proxies', __DIR__);
$classLoader->register();

$pathEntities = array( dirname(__DIR__) . "/src/main/php/Turnos/Core/model" );

$isDevMode = true;
$config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration( $pathEntities, $isDevMode);

$connectionOptions = array(
      'driver'   => 'pdo_mysql',
				    'host'     => "localhost",
				    //'dbname'   => "turnos_core",
					'dbname'   => "instituto_access",
				    'user'     => "root",
				    'password' => "root01"
);

$em = \Doctrine\ORM\EntityManager::create($connectionOptions, $config);

$helpers = array(
    'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
);