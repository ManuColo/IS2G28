<?php
require '../../config/doctrine_config.php';
if (isset($_POST['name'])&&
		($_POST['lastname'])&&
		($_POST['mail'])&&
		($_POST['phone'])&&
		($_POST['password'])&&
		($_POST['name']!=null)&&
		($_POST['lastname']!=null)&&
		($_POST['mail']!=null)&&
		($_POST['phone']!=null)&&
		($_POST['password']!=null)
	){
	$nom=$_POST['name'];
	$ape=$_POST['lastname'];
	$mail=$_POST['mail'];
	$tel=$_POST['phone'];
	$cla=$_POST['password']; 
	$user=new User() ;
	$user->setName ($nom);
	$user->setLastname($ape);
	$user->setMail($mail);
	$user->setPhone($tel);
	$user->setSalt($user->generateSalt());
	$user->setPass($user->encryptPassword($cla,$user->getSalt())); 
	$entityManager-> persist($user);
	$entityManager-> flush();
	header("location:../login/login.php?message=userCreated");
} else {
	header("location:registro.php");
}
?>