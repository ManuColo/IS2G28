<?php

/**
 * Script PHP que define controlador responsable de procesar el formulario de alta de una reputación.
 * 
 * @author Juan
 */

use Symfony\Component\Validator\Validation;
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

// Validar datos de la nueva reputación
$validator = Validation::createValidatorBuilder()
  ->addMethodMapping('loadValidatorMetadata')
  ->getValidator()
;
$violations = $validator->validate($reputation);
$errors = array();
foreach ($violations as $violation) {
  $errors[$violation->getPropertyPath()] = $violation->getMessage();  
}

// Si no hay errores con el nombre de la reputación
// Validar que no exista una reputación con el nombre especificado
if (!isset($errors['name'])) {  
  $anotherReputation = $entityManager->getRepository('Reputation')->findByName($reputation->getName());
  if ($anotherReputation) {
    $errors['name'] = 'Ya existe una reputación con el nombre especificado.';
  }  
}

// Si no hay errores con el puntaje mínimo de la reputación
// Validar que no exista una reputación con el puntaje mínimo especificado
if (!isset($errors['minScore'])) {
  $reputation2 = $entityManager->getRepository('Reputation')->findByMinScore($reputation->getMinScore());
  if ($reputation2) {
    $errors['minScore'] = 'Ya existe una reputación con el puntaje especificado.';
  }  
}

if (count($errors) == 0) {
  // Mover la imagen asociada a la reputación al directorio de uploads
  // Actualizar objeto reputación con la ubicación definitiva de la imagen
  $imageFileName = time() . basename($_FILES['reputation_image']['name']);
  $targetFile = $cfg->uploadDir . $imageFileName;
  move_uploaded_file($reputation->getImage(), $targetFile);    
  $reputation->setImage($imageFileName);

  // Calcular el puntaje maximo de la nueva reputación
  $overlappingReputation = getReputationIncludingScore($reputation->getMinScore());
  $reputation->setMaxScore($overlappingReputation->getMaxScore());
  // Recortar el rango de puntajes cubierto por la reputación superpuesta
  $overlappingReputation->setMaxScore($reputation->getMinScore()-1);
  
  // Persistir nueva reputación en la base de datos
  $entityManager->persist($reputation);
  $entityManager->flush();

  // Redirigir al usuario a la pantalla de alta nuevamente
  header("location:new.php");  
}

// Incluir template que presenta el formulario de creación de una reputación
include 'form.tpl.php';

// Imprimir errores de validacion
/*
if (count($violations) > 0) {
  $errorsString = (string) $violations;
  echo $errorsString;
}
if (count($errors) > 0) {
  echo '<br>';
  var_dump($errors);
} 
*/

 

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
  // Convertir el puntaje mínimo en un valor numérico si corresponde
  $minScore = $reputationData['minScore'];
  if (filter_var($minScore, FILTER_VALIDATE_INT) !== false) {
    $minScore = intval($minScore);
  }    
  $reputation->setMinScore($minScore);
  $reputation->setImage($reputationData['image']);
      
  return $reputation;
}

/**
 * Calcula el puntaje máximo para la reputación dada.
 * 
 * @param Reputation $reputation
 * 
 */
function calculateMaxScore($reputation)
{
  global $entityManager;
  
  // Obtener todas las reputaciones del sistema
  //$reputations = $entityManager->getRepository('Reputation')->findAll();
  
  // Obtener la reputación que le precedería según la escala de puntajes
  
  // Setear el puntaje maximo de la nueva reputación como el maximo de la reputación precedente
  
  // Actualizar maximo de la reputación precedente con el minimo de la nueva reputacion menos 1
  
  // Persistir cambios en la BD
  
  
}

function getReputationIncludingScore($score) 
{
  global $entityManager;
  
  $qb = $entityManager->createQueryBuilder();
  $qb
    ->select('r')
    ->from('Reputation', 'r')
    ->where('r.minScore <= :score')
    ->andWhere('r.maxScore >= :score')
    ->setParameter('score', $score)
  ;
  
  // Obtener consulta
  $query = $qb->getQuery();
  
  // Retornar resultado
  return $query->getSingleResult();
}