<?php 
$cfg = new stdClass();

// Datos de la BBDD
$cfg->driver = 'pdo_mysql';
$cfg->dbname = 'una_gauchada';
$cfg->user = 'root';
$cfg->password = 'UnaGauchada2017';
$cfg->host = 'localhost';

//  Ubicación Base de archivos en filesystem
$cfg->dataRoot = substr(__DIR__, 0, -6);

// Ubicación Base de archivos por URL
$cfg->wwwRoot = 'http://localhost/IS2G28';
//$cfg->wwwRoot = 'http://una-gauchada.localhost/';

// Directorio que contiene archivos subidos por usuarios
$cfg->uploadDir = $cfg->dataRoot.'src/uploads/';

// Agregado de carpeta base en include path
$includePath = substr(__DIR__,0,-7);
set_include_path(get_include_path() . PATH_SEPARATOR . $includePath );

// Seteo de default time zone
date_default_timezone_set('America/Buenos_Aires');