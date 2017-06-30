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

// Recuperar datos de la respuesta de la petición
$answerData = getRequestData($_POST['answer']);

// Buscar pregunta asociada a la respuesta
$answeredQuestion = $entityManager->getRepository('Question')->find($answerData['question_id']);

$favor = $answeredQuestion->getFavor();

// Obtener el usuario logueado en el sistema
$user = $entityManager->getRepository('User')->find($_SESSION['userId']);

// Comprobar que el favor se encuentre activo (no vencido, no despublicado, no aceptado)
if (!$favor->isActive()) {
  addMessage('danger', 'No puede responder en un favor que ya no se encuentra publicado.');
  header("location:show.php?id=". $favor->getId());
}

// Comprobar que sea el dueño del favor quien responde la pregunta
if ($favor->getOwner() !== $user) {
  addMessage('danger', 'No puede responder preguntas en un favor que no le pertenece.');
  header("location:show.php?id=". $favor->getId());
}

// Instanciar respuesta con los datos recibidos
$newAnswer = new Answer();
$newAnswer->setQuestion($answeredQuestion);
$newAnswer->setContent($answerData['content']);

// Validar datos de la nueva respuesta
$validator = Validation::createValidatorBuilder()
  ->addMethodMapping('loadValidatorMetadata')
  ->getValidator()
;
$violations = $validator->validate($newAnswer);
$answerErrors = array();
foreach ($violations as $violation) {
  $answerErrors[$violation->getPropertyPath()] = $violation->getMessage();  
}

// Comprobar si hay errores de validación
// Persistir la nueva pregunta en la base de datos si no hubiera errores de validación
if (count($violations) === 0) {
  
  // Completar datos de la respuesta, como el instante de publicacion
  $newAnswer->setPostedAt(new DateTime());  
  
  // Persistir objeto que modela la pregunta en la base de datos
  $entityManager->persist($newAnswer);
  $entityManager->flush();
  
  // Redirigir al visitante a la vista del favot
  header("location:show.php?id=".$favor->getId());    
}

// Mostrar vista detallada del favor, con los errores del formulario para hacer nueva pregunta
include './show.tpl.php';



// Funciones privadas del controlador
// ==================================

/**
 * Recupera los datos limpios de la respuesta enviados en la petición.
 * 
 * @param array $answerData
 * @return array Datos limpios de una respuesta a una pregunta
 */
function getRequestData($answerData)
{
  $cleanData = array();
  $cleanData['question_id'] = cleanInput($answerData['question_id']);
  $cleanData['content'] = cleanInput($answerData['content']);
  
  return $cleanData;
}
