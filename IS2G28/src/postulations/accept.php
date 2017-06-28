<?php 
require '../common/lib.php';
session_start();
if ($_SESSION['logged']) {
	require_once __DIR__.'/../../config/doctrine_config.php';
	$favorId = cleanInput($_GET['id']);
	$candidateId = cleanInput($_GET['user']);
	$user = $entityManager->getRepository('User')->find($_SESSION['userId']);
} else {
	header("location:../login/login.php?message=accessDenied");
}