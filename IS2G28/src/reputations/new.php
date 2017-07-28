<?php

/**
 * Script PHP que define controlador responsable de presentar el formulario de alta de una nueva reputación.
 * 
 * @author Juan
 */

require_once __DIR__.'/../../config/doctrine_config.php';

session_start();

// Comprobar si el usuario está logueado en el sistema
if (!$_SESSION['logged']) {
  header('location: ../login/login.php');
  exit();
}

// Obtener usuario de la aplicación
$user = $entityManager->getRepository('User')->find($_SESSION['userId']);

// Comprobar si el usuario es un administrador
if (!$user->getIsAdmin()) {
  header('location: ../favors/list.php');
  exit();
}

// Instanciar objeto reputación sin datos para presentar formulario con campos vacíos
$reputation = new Reputation();

// Incluir template que visualiza formulario de creación de una reputación
include 'form.tpl.php';