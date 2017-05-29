<?php

/* 
 * Configuracion de la interfaz de linea de comandos (CLI) de Doctrine.
 * 
 * Este archivo es necesario para que funcione el CLI (Command Line Interface) de Doctrine. Ademas, este
 * archivo debe estar en el directorio raiz del proyecto, desde donde se usa el CLI de Doctrine.
 */

require_once  __DIR__.'/config/doctrine_config.php';

return Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);