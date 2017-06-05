<?php
require '../../config/doctrine_config.php';

// Verifico que lleguen valores por post
if (isset($_POST)&&($_POST['user']!=null)&&($_POST['password']!=null)) {
	//Limpio los valores recibidos
	$params = array_map("cleanInput",$_POST);
	//Valido que reciba un mail como nombre de usuario
	if (!filter_var($params['user'], FILTER_VALIDATE_EMAIL)=== false) {
		//Busco el usuario en base de datos
		$userArr = $entityManager->getRepository('User')->findBy(array('mail'=>$params['user']));
		if (count($userArr) > 0) {
			$user = $userArr[0];
			//Valido que la clave recibida coincida con la que se encuentra en base de datos
			if (($user->encryptPassword($params['password'],$user->getSalt())) == $user->getPass() ) {
				//Cargo en la sesión la información necesaria para el sistema y redirijo al listado
				session_start();
				$_SESSION['logged']=true;
				$_SESSION['loginTime']=time();
				$_SESSION['userId']=$user->getId();
				$_SESSION['message']='Bienvenido';
				header("location:../favors/list.php");
				exit;
			} else {
				header("location:login.php?message=loginFail");
				exit;
			}
		} else {
			header("location:login.php?message=loginFail");
			exit;
		}
	} else {
		header("location:login.php?message=loginFail");
		exit;
	}
}

// Función para limpiar los parámetros

function cleanInput($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}