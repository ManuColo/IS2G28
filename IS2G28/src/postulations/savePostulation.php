<?php
session_start();
require '../../config/doctrine_config.php';
require '../common/lib.php';
if($_SESSION['logged']){
	//Asigno los valores recibidos a variables
	$today= new DateTime();
	$user= $entityManager->getRepository('User')->findBy(array('id'=>$_SESSION['userId']))[0];
	$favor=$_GET['id'];
	//Instancio un nuevo objeto con los datos recibidos
	$postulation=new Postulation();
	$postulation->setDate($today);
	$postulation->setUser($user);
	$postulation->setFavor($favor);
	//$postulation->addMyPostulation($postulation);
	//Inserción en bbdd
	$entityManager-> persist($postulation);
	$entityManager-> flush();
	//Se informa la creación y se redirige al listado de favores
	addMessage('success','Te postulaste al favor');
	header("location:../favors/list.php?message=postComplete");
	exit();
} else {
	header("location:../login/login.php");
	exit();
}?>