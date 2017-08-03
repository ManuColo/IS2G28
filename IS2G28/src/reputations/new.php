<?php

/**
 * Script PHP que define controlador responsable de presentar el formulario de alta de una nueva reputación.
 * 
 * @author Juan
 */

require_once __DIR__.'/../../config/doctrine_config.php';
require_once __DIR__.'/../common/lib.php';

session_start();

// Comprobar si el usuario está logueado en el sistema
// Si no está logueado, redirigirlo a la pantalla de inicio de sesión
if (!$_SESSION['logged']) {
  header("location:../login/login.php?message=accessDenied");
  exit();
}

// Obtener usuario de la aplicación
$user = $entityManager->getRepository('User')->find($_SESSION['userId']);

// Comprobar si el usuario es un administrador
// Si no es administrador, redirigirlo al listado de favores y notificarle el error
if (!$user->getIsAdmin()) {  
  addMessage('danger','Ten&eacute;s que ser administrador para acceder a la función requerida.');
  header('location: ../favors/list.php');
  exit();
}

// Instanciar objeto reputación sin datos para presentar formulario con campos vacíos
$reputation = new Reputation();

// Incluir template que visualiza formulario de creación de una reputación
include 'form.tpl.php';