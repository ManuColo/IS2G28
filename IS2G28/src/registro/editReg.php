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
			//var_dump($_FILES);
			//die();
			//Validaciones de campos en servidor
			if (is_numeric($params['phone']) &&
				!strpbrk($params['name'], '0123456789!"·$%&/()=|@#~½¬{[]}ºª?¿Ç\}_<>-̣+*`^') &&
				!strpbrk($params['lastname'], '0123456789!"·$%&/()=|@#~½¬{[]}ºª?¿Ç\}_<>-̣+*`^')) {
					if (($user->encryptPassword($params['password'],$user->getSalt())) == $user->getPass() ){
						if (!$params['optradio']) {
							if (isset ($_FILES['userPhoto']) && $_FILES['userPhoto']['name']!='') {
								//Validaciones
								$maxFileSize = 1024 * 1000;
								if($_FILES['userPhoto']['size']> $maxFileSize){
									addMessage('danger','La imagen es demasiado grande');
									header("location:./editRegForm.php");
									exit;
								} elseif (!eregi("\.jpg|\.jpeg|\.png|\.bmp|\.gif $",$_FILES['userPhoto']['name'])){
									addMessage('danger','No estás subiendo una imagen');
									header("location:./editRegForm.php");
									exit;
								} else {
								if ($user->getPhoto()){
									$targetFile = $cfg->uploadDir . $user->getPhoto();
									unlink($targetFile);
								}
								// Mover el archivo correspondiente a la foto del favor al directorio de uploads
								$photoFileName = time() . basename($_FILES['userPhoto']['name']);
								$tmpName= $_FILES['userPhoto']['tmp_name'];
								$targetFile = $cfg->uploadDir . $photoFileName;
								move_uploaded_file($tmpName, $targetFile);
								// Actualizar el objeto que modela el favor
								$user->setPhoto($photoFileName);
								}
							}
						} else {
							$targetFile = $cfg->uploadDir . $user->getPhoto();
							unlink($targetFile);
							$user->setPhoto(null);
						}
						//Asigno los valores recibidos a variables
						$nom=$params['name'];
						$ape=$params['lastname'];
						$tel=$params['phone'];
						//Instancio un nuevo objeto con los datos recibidos
						$user->setName ($nom);
						$user->setLastname($ape);
						$user->setPhone($tel);
						//Actualización en bbdd
						$entityManager-> flush();
						addMessage('success','Usuario modificado');
						header("location:../profile/private.php");
					} else {
						addMessage('danger', 'Clave incorrecta');
						include 'editRegForm.php';
					}
				} else {
				//Uno o varios de los datos no pasaron las validaciones del servidor
				addMessage('danger','Error en los campos ingresados');
				include 'editRegForm.php';
				}
					
		} else {
			//Los campos no llegan completos desde el formulario
			addMessage('danger','Falta completar campos');
			include 'editRegForm.php';
		}				
} else {
	header("location:../login/login.php?message=accessDenied");
	exit();
}
?>