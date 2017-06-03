<?php
require '../../config/doctrine_config.php';
//Verifico la llegada de los datos completos
if (isset($_POST['name'])&&
	($_POST['lastname'])&&
	($_POST['mail'])&&
	($_POST['phone'])&&
	($_POST['password'])&&
	($_POST['name']!=null)&& (trim($_POST['name']) != '')&&
	($_POST['lastname']!=null)&& (trim($_POST['lastname']) != '')&&
	($_POST['mail']!=null)&& (trim($_POST['mail']) != '')&&
	($_POST['phone']!=null)&& (trim($_POST['phone']) != '')&&
	($_POST['password']!=null)&&(trim($_POST['password']) != '')) {
		//Validaciones de campos en servidor
		if (filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL) === FALSE &&
		is_numeric($_POST['phone']) &&
		!strpbrk($_POST['name'], '0123456789!"·$%&/()=|@#~½¬{[]}ºª?¿Ç\}_<>-̣+*`^') && 
		!strpbrk($_POST['lastname'], '0123456789!"·$%&/()=|@#~½¬{[]}ºª?¿Ç\}_<>-̣+*`^')) {
			//Verifico si el mail existe en la base de datos
			$compare = $entityManager->getRepository('User')->findBy(array('mail'=>$_POST['mail']))[0];
			if($compare == null){
				//Asigno los valores recibidos a variables
				$nom=$_POST['name'];
				$ape=$_POST['lastname'];
				$mail=$_POST['mail'];
				$tel=$_POST['phone'];
				$cla=$_POST['password']; 
				//Instancio un nuevo objeto con los datos recibidos
				$user=new User() ;
				$user->setName ($nom);
				$user->setLastname($ape);
				$user->setMail($mail);
				$user->setPhone($tel);
				$user->setSalt($user->generateSalt());
				$user->setPass($user->encryptPassword($cla,$user->getSalt()));
				$user->setCantCredits(1);
				//Inserción en bbdd
				$entityManager-> persist($user);
				$entityManager-> flush();
				//Se informa la creación y se redirige al login
				//$_SESSION['error']= "Inicia Sesion para continuar";
				header("location:../login/login.php?message=userCreated");
			} 
			else {
				//El mail que intento ingresar ya existe en la bbdd
				//$_SESSION['error']= "Tu e-mail ya existe en nuestra base de datos";
				header("location:registro.php?message=userExists");
			} 
		} else {
			//Uno o varios de los datos no pasaron las validaciones del servidor
			header("location:registro.php?message=camposIncorrectos");
			echo "Verific&aacute; los datos ingresados";
		}
			
	} else {
		//Los campos no llegan completos desde el formulario
		//$_SESSION['error']= "Información enviada incompleta";
		header("location:registro.php?message=notComplete");
}
?>