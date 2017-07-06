<?php
require '../common/lib.php';
session_start();
if ($_SESSION['logged']) {
	require_once __DIR__.'/../../config/doctrine_config.php';
	$user= $entityManager->find('User',$_SESSION['userId']);
	if ($user->getIsAdmin()) {
		$newAdmin =  $user= $entityManager->find('User',cleanInput($_GET['idUs']));
		$newAdmin->setIsAdmin(True);
		$entityManager->persist($newAdmin);
		$entityManager->flush();
		addMessage('success','Se ha nombrado administrador a ' . $newAdmin->getName());
		header("location:../profile/public.php?idUs=".$newAdmin->getId());
	} else {
		addMessage('danger','Ten&eacute;s que ser administrador para acceder');
		header("location:../favors/list.php");
	}
} else {
	header("location:../login/login.php?message=accessDenied");
}