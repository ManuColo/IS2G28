<?php

/* 
 * Configuracion del gestor de entidades del ORM Doctrine.
 * 
 * El gestor de entidades (EntityManager) es la interfaz publica de Doctrine, puesto que provee puntos de
 * acceso al ciclo de vida de las entidades, asi como tambien permite convertir las entidades hacia/desde
 * la base de datos.
 */

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/config.php';

// Crear configuracion default para el ORM Doctrine
$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__.'/../src/model'), $isDevMode);

// Especificar parametros de configuracion de la base de datos
$conn = array(
	'driver' => $cfg->driver,
	'dbname' => $cfg->dbname,
	'user' => $cfg->user,
	'password' => $cfg->password,
	'host' => $cfg->host
);

// Obtener gestor de entidades del ORM Doctrine
$entityManager = EntityManager::create($conn, $config);

