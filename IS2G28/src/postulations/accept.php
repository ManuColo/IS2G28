<?php 
require '../common/lib.php';
session_start();
if ($_SESSION['logged']) {
	require_once __DIR__.'/../../config/doctrine_config.php';
	$favorId = cleanInput($_GET['id']);
	$candidateId = cleanInput($_GET['user']);
	$user = $entityManager->getRepository('User')->find($_SESSION['userId']);
	$favor= $entityManager->getRepository('Favor')->find($_GET['id']);
	$candidate = $entityManager->getRepository('User')->find($candidateId);
	if ($favor->getOwner() === $user) {
		foreach ($favor->getMyPostulations() as $postulation) {
			if ($postulation->getUser() === $candidate) {
				$postulation->accept();
				$candidate->addCredits();
				$entityManager->persist($candidate);
			} else {
				$postulation->reject();
			}
			$entityManager->persist($postulation);
		}
		$favor->setResolved(True);
		$entityManager->persist($favor);
		$entityManager->flush();
		addMessage('info','Se aceptó al candidato '.$candidate.' y se rechazó a los restantes. Se enviaron los datos de contacto. La gauchada ya no estará visible en el listado');
		header("location:../favors/list.php");
	} else {
		addMessage('danger','No pod&eacute;s aceptar postulantes en una gauchada que no es tuya');
		header("location:../favors/list.php");
	}
} else {
	header("location:../login/login.php?message=accessDenied");
}