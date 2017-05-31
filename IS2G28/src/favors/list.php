<?php
session_start();
if ($_SESSION['logged']) {
	require '../../config/doctrine_config.php';
	$favors = $entityManager->getRepository("Favor");
} else {
	header("location:../login/login.php");
}