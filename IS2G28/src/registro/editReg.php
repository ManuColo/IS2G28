<?php
session_start();
require '../../config/doctrine_config.php';
require '../common/lib.php';
if ($_SESSION['logged']) {
	$user= $entityManager->getRepository('User')->findBy(array('id'=>$_SESSION['userId']))[0];
	//Limpio los valores recibidos
	$params = array_map("cleanInput",$_POST);
	//Verifico la llegada de los datos completos
	if (isset($params['name'])&&
		($params['lastname'])&&
		($params['phone'])&&
		($params['password'])&&
		($params['name']!=null)&&
		($params['lastname']!=null)&&
		($params['phone']!=null)&&
		($params['password']!=null)) {
			//Validaciones de campos en servidor
			if (is_numeric($params['phone']) &&
				!strpbrk($params['name'], '0123456789!"·$%&/()=|@#~½¬{[]}ºª?¿Ç\}_<>-̣+*`^') &&
				!strpbrk($params['lastname'], '0123456789!"·$%&/()=|@#~½¬{[]}ºª?¿Ç\}_<>-̣+*`^')) {
				//Asigno los valores recibidos a variables
					$nom=$params['name'];
					$ape=$params['lastname'];
					$tel=$params['phone'];
					//Instancio un nuevo objeto con los datos recibidos
					$user->setName ($nom);
					$user->setLastname($ape);
					$user->setPhone($tel);
					//Actualización en bbdd
					$flush= $entityManager-> flush();
					addMessage('success','Usuario modificado');
					header("location:editRegForm.php");
				} else {
				//Uno o varios de los datos no pasaron las validaciones del servidor
				addMessage('danger','Error en los campos ingresados');
				include 'registro.php';
			}
					
		} else {
			//Los campos no llegan completos desde el formulario
			addMessage('danger','Falta completar campos');
			include 'registro.php';
		}
} else {
	header("location:../login/login.php");
	exit();
}?>
