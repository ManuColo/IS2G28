<?php
require '../common/lib.php';
session_start();
if ($_SESSION['logged']) {
	require_once __DIR__.'/../../config/doctrine_config.php';
	$favorId = cleanInput($_GET['id']);
	$user = $entityManager->getRepository('User')->find($_SESSION['userId']);
	$favor = $entityManager->getRepository('Favor')->find($favorId);
	$postulations = $favor->getMyPostulations();
	if (!$favor->getUnpublished()) {
		if ($favor->getOwner()=== $user) {
			$favor->setUnpublished(True);
			if ($postulations->count() === 0) {
				$user->addCredits();
				$entityManager->persist($user);
				addMessage('success','La gauchada ya no será visible');
			} else {
				foreach ($postulations as $postulation) {
					if ($postulation->getStatus() === 'Pendiente'){
						$postulation->reject();
					}
				}
				addMessage('info','La gauchada ya no será visible, se ha notificado a los postulantes');
			}
			$entityManager->persist($favor);
			$entityManager->flush();
			header("location:list.php");
		} else {
			addMessage('danger','No pod&eacute;s despublicar una gauchada que no es tuya');
			header("location:show.php?id=".$favorId);
		}
	} else {
		addMessage('danger','No pod&eacute;s despublicar una gauchada que no est&aacute; publicada');
		header("location:list.php");
	}
} else {
	header("location:../login/login.php?message=accessDenied");
}
