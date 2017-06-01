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
		//Verifico si el mail existe en la base de datos
		$compare = $entityManager->getRepository('User')->findBy(array('mail'=>$_POST['mail']))[0];
		if($compare == null){
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
			//$_SESSION['error']= "Inicia Sesion para continuar";
			header("location:../login/login.php?message=userCreated");
		} 
			else {
			//$_SESSION['error']= "Tu e-mail ya existe en nuestra base de datos";
			header("location:registro.php?message=userExists");
		} 
	} 
	else {
		//$_SESSION['error']= "Información enviada incompleta";
		header("location:registro.php?message=notComplete");
}
?>