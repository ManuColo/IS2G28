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

?>