<?php

/**
 * Script PHP que define controlador responsable de procesar el formulario de edición de una reputación dada.
 * 
 * @author Juan
 */

use Symfony\Component\Validator\Validation;

require_once __DIR__.'/../../config/doctrine_config.php';
require_once __DIR__.'/../common/lib.php';

session_start();

// Redirigir usuario no logueado a la pagina de login
if (!$_SESSION['logged']) {
  header("location:../login/login.php");
}

// Recuperar datos editados de la reputación desde la peticion
$reputationData = getRequestData($_POST['reputation'], $_FILES);
// Obtener el ID de la reputación a modificar
$reputationId = filter_var($_POST['reputation']['id'], FILTER_VALIDATE_INT, array(
    'options' => array('min_range' => 1)
));

// Recuperar la reputación con el ID dado
// Si no existe, redirigir al usuario al listado de reputationes notificandole el error
$reputation = $entityManager->getRepository('Reputation')->find($reputationId);
if (!$reputation) {
  addMessage('danger', 'No existe la reputación especificada.');
  header('location:list.php');
  exit();
}

// Guardar en una variable auxiliar la imagen actual de la reputación
$currentReputationImage = $reputation->getImage(); 
// Cargar los datos actualizados al objeto reputacion
$reputation = updateReputation($reputation, $reputationData);

// Validar datos de la reputación actualizada
$validator = Validation::createValidatorBuilder()
  ->addMethodMapping('loadValidatorMetadata')
  ->getValidator()
;
// El ultimo parámetro del metodo validate() permite especificar que solo se apliquen las reglas de validación
// que pertenecen al grupo especificado
$violations = $validator->validate($reputation, null, array('edition'));
$errors = array();
foreach ($violations as $violation) {
  $errors[$violation->getPropertyPath()] = $violation->getMessage();  
}

// Si no hay errores con el nombre de la reputación
// Validar que no exista otra reputación con el nombre especificado
if (!isset($errors['name'])) {  
  $anotherReputation = $entityManager->getRepository('Reputation')->findOneByName($reputation->getName());
  if ($anotherReputation && $anotherReputation->getId() != $reputation->getId()) {
    $errors['name'] = 'Ya existe una reputación con el nombre especificado.';
  }  
}

// Si no hay errores con el puntaje mínimo de la reputación
// Validar que no exista otra reputación con el puntaje mínimo especificado
if (!isset($errors['minScore'])) {
  $anotherReputation = $entityManager->getRepository('Reputation')->findOneByMinScore($reputation->getMinScore());
  if ($anotherReputation && $anotherReputation->getId() != $reputation->getId()) {
    $errors['minScore'] = 'Ya existe una reputación con el puntaje especificado.';
  }  
}

if (count($errors) == 0) {  
  // Comprobar si se actualizó la imagen de la reputación
  if ($reputation->getImage()) {
    // Remover del sistema de archivos la imagen actual de la reputación    
    unlink($cfg->uploadDir . $currentReputationImage);    
    // Mover la nueva imagen asociada a la reputación al directorio de uploads
    // Actualizar objeto reputación con la ubicación definitiva de la imagen
    $imageFileName = time() . basename($_FILES['reputation_image']['name']);
    $targetFile = $cfg->uploadDir . $imageFileName;
    move_uploaded_file($reputation->getImage(), $targetFile);    
    $reputation->setImage($imageFileName);      
  } else {  
    // Si no se actualizo la imagen de la reputacion,
    // Entonces dejar la imagen original
    $reputation->setImage($currentReputationImage);    
  }
  
  // Persistir nueva reputación en la base de datos
  $entityManager->persist($reputation);
  $entityManager->flush();

  // Redirigir al usuario al listado de reputaciones
  addMessage('success', 'Se ha actualizado la reputación "' . $reputation->getName() . '" exitosamente.');
  header("location:list.php");
  exit();
}

// Incluir template que contiene el formulario de reputación para mostrar los errores
$reputation->setImage($currentReputationImage);
include 'form.tpl.php';




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
 * Retorna el objeto reputación con sus datos actualizados.
 * 
 * @param Reputation $reputation
 * @param array $reputationData
 * @return Reputation
 */
function updateReputation(Reputation $reputation, $reputationData)
{
  $reputation->setName($reputationData['name']);
  $reputation->setImage($reputationData['image']);
  // Convertir el puntaje mínimo en un valor numérico si corresponde
  $minScore = $reputationData['minScore'];
  if (filter_var($minScore, FILTER_VALIDATE_INT) !== false) {
    $minScore = intval($minScore);
  }    
  $reputation->setMinScore($minScore);
  
  
  return $reputation;
}