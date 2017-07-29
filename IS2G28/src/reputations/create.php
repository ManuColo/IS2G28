<?php

/**
 * Script PHP que define controlador responsable de procesar el formulario de alta de una reputación.
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

// Recuperar datos de la reputación desde la peticion
$reputationData = getRequestData($_POST['reputation'], $_FILES);
$reputation = createReputation($reputationData);

// Mover la imagen asociada a la reputación al directorio de uploads
// Actualizar objeto reputación con la ubicación definitiva de la imagen
$imageFileName = time() . basename($_FILES['reputation_image']['name']);
$targetFile = $cfg->uploadDir . $imageFileName;
move_uploaded_file($reputation->getImage(), $targetFile);    
$reputation->setImage($imageFileName);

// Persistir nueva reputación en la base de datos
$entityManager->persist($reputation);
$entityManager->flush();

// Redirigir al usuario a la pantalla de alta nuevamente
header("location:new.php");
 


// ===============================================================================
// Funciones privadas
// ===============================================================================

/**
 * Retorna los datos de la reputación enviados en la peticion en una version limpia.
 * Esto significa que se remueven los espacios en blanco y se convierten los
 * caracteres especiales en entidades HTML para evitar ataques CSRF y otras
 * problemas de seguridad.
 * 
 * @param array $requestData
 * @return array
 */
function getRequestData($requestData, $requestFiles) 
{
  $reputationData = array();
  $reputationData['name'] = cleanInput($requestData['name']);
  $reputationData['minScore'] = cleanInput($requestData['minScore']);
  $reputationData['image'] = $requestFiles['reputation_image']['tmp_name'];

  return $reputationData;
}

/**
 * Retorna un nuevo objeto Reputation que se inicializa con los datos limpios de la reputación
 * obtenidos desde la peticion.
 * 
 * @param array $reputationData
 * @return \Reputation
 */
function createReputation($reputationData) 
{
  $reputation = new Reputation();
  $reputation->setName($reputationData['name']);
  $reputation->setMinScore($reputationData['minScore']);
  $reputation->setImage($reputationData['image']);
      
  return $reputation;
}