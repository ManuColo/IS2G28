<?php
session_start();
require '../../config/doctrine_config.php';
require '../common/lib.php';
if ($_SESSION['logged']) {
//Limpio los valores recibidos
$params = array_map("cleanInput",$_POST);
//Verifico la llegada de los datos completos
if (isset($params['card'])&&
	($params['titCard'])&&
	($params['numCard'])&&
	($params['cardE'])&&
	($params['cardV'])&&
	($params['codCard'])&&
	($params['cantCredReq'])&&	
	($params['card']!=null)&&
	($params['titCard']!=null)&&
	($params['numCard']!=null)&&
	($params['cardE']!=null)&&
	($params['cardV']!=null)&&
	($params['codCard']!=null)&&
	($params['cantCredReq']!=null)){
		//Validaciones de campos en servidor
		if (!strpbrk($params['titCard'], '0123456789!"·$%&/()=|@#~½¬{[]}ºª?¿Ç\}_<>-̣+*`^') &&
		is_numeric($params['numCard']) && strlen($params['numCard'])== 16 &&
		is_numeric($params['codCard'])&& strlen($params['codCard'])== 3 &&
		$params['cardE'] < $params['cardV'] && 
		(strtotime($params['cardV'])>= strtotime(date('m/y')))) {
			//Codigo de Seguridad que genera falla en servidor externo			
			if($params['codCard']== "111"){
				header("location:./buyFail.php");
			} else {
				//Datos de tarjeta para enviar al servidor externo
				$card=$params['card'];
				$tit=$params['titCard'];
				$num=$params['numCard'];
				$emision=$params['cardE'];
				$venc=$params['cardV'];
				$cod=$params['codCard'];
				//Datos para la bbdd
				$today= new DateTime();
				$cantCred=$params['cantCredReq'];
				$user= $entityManager->find('User',$_SESSION['userId']);
				//Instancio nuevo objeto crédito
				$credit=new Credit();
				$credit->setOperationDate($today);
				$credit->setCantidad($cantCred);
				$credit->setUserId($user);
				//Incremento la cantidad de créditos del usuario
				$user->addCredits($cantCred);
				//Inserción en bbdd
				$entityManager-> persist($credit);
				$entityManager-> persist($user);
				$entityManager-> flush();
				header("location:./buyComplete.php");
				
			}
		} else {
			//Uno o varios de los datos no pasaron las validaciones del servidor
			addMessage('danger','Error en los campos ingresados');
			header("location:formCredits.php");
			exit();
		}
} else {
	//Los campos no llegan completos desde el formulario
	addMessage('danger','Hay campos sin completar');
	header("location:formCredits.php");
	exit();
}
}else {
	header("location:../login/login.php");
	exit();
}
?>