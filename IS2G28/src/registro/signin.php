<?php
require '../../config/doctrine_config.php';
require '../common/lib.php';

//Limpio los valores recibidos
$params = array_map("cleanInput",$_POST);
//Verifico la llegada de los datos completos
if (isset($params['name'])&&
	($params['lastname'])&&
	($params['mail'])&&
	($params['phone'])&&
	($params['password'])&&
	($params['name']!=null)&&
	($params['lastname']!=null)&& 
	($params['mail']!=null)&& 
	($params['phone']!=null)&& 
	($params['password']!=null)) {
		//Validaciones de campos en servidor
		if (!filter_var($params['mail'], FILTER_VALIDATE_EMAIL) === false &&
		is_numeric($params['phone']) &&
		!strpbrk($params['name'], '0123456789!"·$%&/()=|@#~½¬{[]}ºª?¿Ç\}_<>-̣+*`^') && 
		!strpbrk($params['lastname'], '0123456789!"·$%&/()=|@#~½¬{[]}ºª?¿Ç\}_<>-̣+*`^')) {
			//Verifico si el mail existe en la base de datos
			$compare = $entityManager->getRepository('User')->findBy(array('mail'=>$_POST['mail']))[0];
			if($compare == null){
				//Asigno los valores recibidos a variables
				$nom=$params['name'];
				$ape=$params['lastname'];
				$mail=$params['mail'];
				$tel=$params['phone'];
				$cla=$params['password']; 
				//Instancio un nuevo objeto con los datos recibidos
				$user=new User() ;
				$user->setName ($nom);
				$user->setLastname($ape);
				$user->setMail($mail);
				$user->setPhone($tel);
				$user->setSalt($user->generateSalt());
				$user->setPass($user->encryptPassword($cla,$user->getSalt()));
				//Inserción en bbdd
				$entityManager-> persist($user);
				$entityManager-> flush();
				//Se informa la creación y se redirige al login
				header("location:../login/login.php?message=userCreated");
			} 
			else {
				//El mail que intento ingresar ya existe en la bbdd
				//header("location:registro.php?message=userExists");
				include 'registro.php';
			} 
		} else {
			//Uno o varios de los datos no pasaron las validaciones del servidor
			//header("location:registro.php?message=camposIncorrectos");
			include 'registro.php';
		}
			
	} else {
		//Los campos no llegan completos desde el formulario
		//header("location:registro.php?message=notComplete");
		include 'registro.php';
}
?>