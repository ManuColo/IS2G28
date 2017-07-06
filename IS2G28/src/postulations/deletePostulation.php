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
		$entityManager->remove($postulation);
		$entityManager->flush();
		addMessage('warning','Ya no est&aacute;s postulado a la gauchada');
		header("location:../favors/show.php?id=".$postulation->getFavor()->getId());
	}
} else {
	header("location:../login/login.php?message=accessDenied");
}
?>