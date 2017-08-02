<?php

/**
 * Script PHP que define controlador responsable de presentar el formulario de edición de una reputación dada.
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

// Recuperar el ID de la reputación a editar
$reputationId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

// Obtener la reputación especificada por el ID enviado en la petición
$reputation = $entityManager->getRepository('Reputation')->find($reputationId);
// Comprobar que exista la reputación especificada
// Si no existe tal reputación, redirigir al listado de reputaciones y notificar el error
if (!$reputation) {
  addMessage('danger', 'No existe la reputación especificada.');  
  header("location:list.php");
  exit();  
}

// Incluir template que visualiza formulario vinculado a una reputación
include 'form.tpl.php';