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

// Recuperar datos de la pregunta de la petición
$questionData = getRequestData($_POST['question']);

// Buscar favor asociado a la pregunta
$favor = $entityManager->getRepository('Favor')->find($questionData['favor_id']);

// Obtener el usuario logueado en el sistema
$user = $entityManager->getRepository('User')->find($_SESSION['userId']);

// Comprobar que el favor se encuentre activo (no vencido, no despublicado, no aceptado)
if (!$favor->isActive()) {  
  addMessage('danger', 'No puede publicarse una pregunta en un favor que ya no está publicado.');
  header("location:show.php?id=". $favor->getId());
  exit();
}

// Comprobar que el dueño del favor no haga la pregunta
if ($favor->getOwner() === $user) { 
  addMessage('danger', 'El dueño del favor no puede publicar una pregunta en uno de sus favores.');
  header("location:show.php?id=". $favor->getId());
  exit();
}

// Instanciar pregunta con los datos recibidos
$newQuestion = new Question();
$newQuestion->setFavor($favor);
$newQuestion->setContent($questionData['content']);

// Validar datos de la nueva pregunta
$validator = Validation::createValidatorBuilder()
  ->addMethodMapping('loadValidatorMetadata')
  ->getValidator()
;
$violations = $validator->validate($newQuestion);
$errors = array();
foreach ($violations as $violation) {
  $errors[$violation->getPropertyPath()] = $violation->getMessage();  
}

// Comprobar si hay errores de validación
// Persistir la nueva pregunta en la base de datos si no hubiera errores de validación
if (count($violations) === 0) {
  
  // Completar datos de la pregunta, como el autor y el instante de publicación
  $newQuestion->setAuthor($user);
  $newQuestion->setPostedAt(new DateTime());
  
  // Persistir objeto que modela la pregunta en la base de datos
  $entityManager->persist($newQuestion);
  $entityManager->flush();
  
  // Redirigir al visitante a la vista del favot
  header("location:show.php?id=".$favor->getId());    
}

// Mostrar vista detallada del favor, con los errores del formulario para hacer nueva pregunta
include './show.tpl.php';



// Funciones privadas del controlador
// ==================================

/**
 * Recupera los datos limpios de la pregunta enviados en la petición.
 * 
 * @param array $questionData
 * @return array Datos limpios de una pregunta
 */
function getRequestData($questionData)
{
  $cleanData = array();
  $cleanData['favor_id'] = cleanInput($questionData['favor_id']);
  $cleanData['content'] = cleanInput($questionData['content']);
  
  return $cleanData;
}