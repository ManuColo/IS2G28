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

// Validar que la calificación del dueño sea realizada por quien hizo la gauchada
if ($user !== $favor->getAcceptedPostulant()) {
	addMessage('danger', 'Solo quien realiz&oacute; la gauchada puede calificar al due&ntilde;o.');
	header("location:../favors/show.php?id=". $favor->getId());
	exit();
}

// Validar que el favor este resuelto para poder calificarlo
if (!$favor->getResolved()) {
	addMessage('danger', 'No se puede calificar una gauchada no resuelta.');
	header("location:../favors/show.php?id=". $favor->getId());
	exit();
}

// Validar que el favor no tenga una calificación para el dueño
if ($favor->getOwnerQualification()) {
	addMessage('danger', 'Ya se ha calificado al due&ntilde;o de la gauchada.');
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
	
	// Setear calificación del dueño de la gauchada
	$favor->setOwnerQualification($qualification);
	// Sumar reputación al postulante aceptado
	$owner = $favor->getOwner();
	if (!$owner->getReputation()) {
		$owner->setReputation(0);
	}
	$owner->setReputation($owner->getReputation() + $qualification->getResult());
	
	
	$entityManager->persist($owner);
	$entityManager->persist($qualification);
	$entityManager->flush();
	
	addMessage('success', 'Se ha calificado exitosamente al due&ntilde;o de la gauchada.');
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