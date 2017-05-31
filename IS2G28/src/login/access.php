<?php
require '../../config/doctrine_config.php';
if (isset($_POST)&&($_POST['user']!=null)&&($_POST['password']!=null)) {
	if (!filter_var($_POST['user'], FILTER_VALIDATE_EMAIL)=== false) {
		$user = $entityManager->getRepository('User')->findBy(array('mail'=>$_POST['user']))[0];
		if (($user->encryptPassword($_POST['password'],$user->getSalt())) == $user->getPass() ) {
			session_start();
			$_SESSION['logged']=true;
			$_SESSION['loginTime']=date();
			$_SESSION['userId']=$user->getId();
			header("location:../favors/");
		}
		
	} else {
		header("location:login.php?message=loginFail");
	}
}