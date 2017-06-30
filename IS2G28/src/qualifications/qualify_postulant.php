<?php

use Symfony\Component\Validator\Validation;

session_start();
// Comprobar si el usuario está logueado, sino redirigirlo a la pantalla de login
if (!$_SESSION['logged']) {
  header("location:../login/login.php");
}

// Incluir código php necesario para esta función
require_once __DIR__.'/../../config/doctrine_config.php';
require_once __DIR__.'/../common/lib.php';

// Recuperar datos de la calificación
$qualificationData = getRequestData($_POST['qualification']);

// Buscar favor asociado a la calificación
$favor = $entityManager->getRepository('Favor')->find($qualificationData['favor_id']);
// Obtener el usuario logueado en el sistema
$user = $entityManager->getRepository('User')->find($_SESSION['userId']);

// Validar que la calificación del postulante sea realizada por el dueño de la gauchada
if ($user !== $favor->getOwner()) {
  addMessage('danger', 'Solo el dueño del favor puede calificar al postulante que realizó la gauchada.');
  header("location:../favors/show.php?id=". $favor->getId());
  exit();
}

// Validar que el favor este resuelto para poder calificarlo
if (!$favor->getResolved()) {
  addMessage('danger', 'No se puede calificar una gauchada no resuelta.');
  header("location:../favors/show.php?id=". $favor->getId());
  exit();
}

// Validar que el favor no tenga una calificación para el postulante
if ($favor->getPostulantQualification()) {
  addMessage('danger', 'Ya se ha calificado al postulante que realizó la gauchada.');
  header("location:../favors/show.php?id=". $favor->getId());
  exit();
}

// Instanciar nueva calificación con los datos obtenidos
$qualification = new Qualification();
$qualification->setResult($qualificationData['result']);
$qualification->setComment($qualificationData['comment']);

// Validar datos de la calificación realizada
$validator = Validation::createValidatorBuilder()
  ->addMethodMapping('loadValidatorMetadata')
  ->getValidator()
;
$violations = $validator->validate($qualification);
$errors = array();
foreach ($violations as $violation) {
  $errors[$violation->getPropertyPath()] = $violation->getMessage();  
}

if (count($violations) === 0) {  
  $qualification->setCreatedAt(new DateTime());
  
  // Setear calificación del postulante a la gauchada
  $favor->setPostulantQualification($qualification);
  // Sumar reputación al postulante aceptado
  $postulant = $favor->getAcceptedPostulant();
  if (!$postulant->getReputation()) {
    $postulant->setReputation(0);    
  }
  $postulant->setReputation($postulant->getReputation() + $qualification->getResult());
  

  $entityManager->persist($postulant);
  $entityManager->persist($qualification);  
  $entityManager->flush();
  
  addMessage('success', 'Se ha calificado exitosamente al postulante que realizó la gauchada.');
  header("location:../favors/show.php?id=". $favor->getId());
  exit();
  
}




// Funciones privadas del controlador
// ==================================

/**
 * Recupera los datos limpios de la calificación
 * 
 * @param array $qualificationData
 * @return array Datos limpios de una calificación
 */
function getRequestData($qualificationData)
{
  $cleanData = array();
  $cleanData['favor_id'] = cleanInput($qualificationData['favor_id']);
  $cleanData['result'] = cleanInput($qualificationData['result']);
  $cleanData['comment'] = cleanInput($qualificationData['comment']);
  
  return $cleanData;
}