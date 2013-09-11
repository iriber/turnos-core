<?php

include_once '../conf/init.php';


$classLoader = new \Doctrine\Common\ClassLoader('Entities', __DIR__);
$classLoader->register();

$classLoader = new \Doctrine\Common\ClassLoader('Proxies', __DIR__);
$classLoader->register();


$isDevMode = true;
$config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration( explode(",", CDT_ENTITIES_PATH), $isDevMode);

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