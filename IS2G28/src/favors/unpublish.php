<?php
require '../common/lib.php';
session_start();
if ($_SESSION['logged']) {
	require_once __DIR__.'/../../config/doctrine_config.php';
	$favorId = cleanInput($_GET['id']);
	$user = $entityManager->getRepository('User')->find($_SESSION['userId']);
	$favor = $entityManager->getRepository('Favor')->find($favorId);
	if ($favor->getOwner()=== $user) {
		$favor->setUnpublished(True);
		$entityManager->persist($favor);
		$entityManager->flush();
		addMessage('success','La gauchada ya no será visible');
		header("location:list.php");
	} else {
		addMessage('danger','No pod&eacute;s despublicar una gauchada que no es tuya');
		header("location:show.php?id=".$favorId);
	}
} else {
	header("location:../login/login.php?message=accessDenied");
}
