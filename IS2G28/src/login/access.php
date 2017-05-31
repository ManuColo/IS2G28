<?php
require '../../config/doctrine_config.php';
if (isset($_POST)&&($_POST['user']!=null)&&($_POST['password']!=null)) {
	if (!filter_var($_POST['user'], FILTER_VALIDATE_EMAIL)=== false) {
		$user = $entityManager->getRepository('User')->findBy(array('mail'=>$_POST['user']));
		var_dump($user);
		var_dump($_POST['user']);
	} else {
		header("location:login.php?message=loginFail");
	}
}