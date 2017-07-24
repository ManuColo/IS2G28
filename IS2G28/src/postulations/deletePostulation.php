<?php
require '../../config/doctrine_config.php';
require '../common/lib.php';
if (!isset($_SESSION)) {
	session_start();
}
if ($_SESSION['logged']) {
	$postulation = $entityManager->getRepository('Postulation')->find(cleanInput($_GET['postulation']));
	$user = $entityManager->getRepository('User')->find($_SESSION['userId']);
	if ($postulation->getUser() === $user) {
		if (!$postulation->getFavor()->getResolved()){
		$entityManager->remove($postulation);
		$entityManager->flush();
		addMessage('warning','Ya no est&aacute;s postulado a la gauchada');
		header("location:../favors/show.php?id=".$postulation->getFavor()->getId());
		} else {
			addMessage('danger', 'No pod&eacute;s despostularte a un favor resuelto');
			header("location:../favors/show.php?id=".$postulation->getFavor()->getId());
			
		}
	} else {
		addMessage('danger', 'No est&aacute;s postulado a este favor');
		header("location:../favors/show.php?id=".$postulation->getFavor()->getId());
	}
} else {
	header("location:../login/login.php?message=accessDenied");
}
?>