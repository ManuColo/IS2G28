<?php

/**
 * Script PHP que define controlador responsable de eliminar una reputación dada.
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

// Comprobar si la reputación es borrable
// Si no lo es, redirigir al listado de reputaciones y notificar el error
if ($reputation->isDefault()) {
  addMessage('danger', 'No puede borrarse la reputación especificada.');  
  header("location:list.php");
  exit();  
}

// Guardar el nombre de la reputación para mostrarle en el mensaje de feedback
$reputationName = $reputation->getName();

// Remover del sistema de archivos la imagen actual de la reputación    
unlink($cfg->uploadDir . $reputation->getImage()); 
// Remover reputación de la base de datos
$entityManager->remove($reputation);
$entityManager->flush();

// Redirigir al usuario al listado de reputaciones
addMessage('success', 'Se ha borrado la reputación "' . $reputationName . '" exitosamente.');
header("location:list.php");
exit();