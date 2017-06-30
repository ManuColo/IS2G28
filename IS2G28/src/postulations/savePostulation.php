<?php
session_start();
require '../../config/doctrine_config.php';
require '../common/lib.php';
if($_SESSION['logged']){
	//Asigno los valores recibidos a variables
	$today= new DateTime();
	$user= $entityManager->getRepository('User')->findBy(array('id'=>$_SESSION['userId']))[0];
	$favor= $entityManager->getRepository('Favor')->findBy(array('id'=>$_GET['id']))[0];
	$comment=$_POST['comment'];
	//Instancio un nuevo objeto con los datos recibidos
	$postulation=new Postulation();
	$postulation->setDate($today);
	$postulation->setUser($user);
	$postulation->setFavor($favor);
	$postulation->setComment($comment);
	//Inserción en bbdd
	$entityManager-> persist($postulation);
	$entityManager-> flush();
	//Se informa la creación y se redirige al listado de favores
	addMessage('success','Te postulaste al favor');
	header("location:../favors/list.php");
	exit();
} else {
	header("location:../login/login.php?message=accessDenied");
	exit();
}?>