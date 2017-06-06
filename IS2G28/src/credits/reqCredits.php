<?php
session_start();
require '../../config/doctrine_config.php';?>
<script src="moment.min.js"></script>
<?php
if (isset($_POST['card'])&&
	($_POST['titCard'])&&
	($_POST['numCard'])&&
	($_POST['cardE'])&&
	($_POST['cardV'])&&
	($_POST['codCard'])&&
	($_POST['cantCredReq'])&&
	($_POST['card']!=null)&& (trim($_POST['card']) != '')&&
	($_POST['titCard']!=null)&& (trim($_POST['titCard']) != '')&&
	($_POST['numCard']!=null)&& (trim($_POST['numCard']) != '')&&
	($_POST['cardE']!=null)&& (trim($_POST['cardE']) != '')&&
	($_POST['cardV']!=null)&& (trim($_POST['cardV']) != '')&&
	($_POST['codCard']!=null)&& (trim($_POST['codCard']) != '')&&
	($_POST['cantCredReq']!=null)&& (trim($_POST['cantCredReq']) != '')){
		//Validaciones de campos en servidor
		if (!strpbrk($_POST['titCard'], '0123456789!"·$%&/()=|@#~½¬{[]}ºª?¿Ç\}_<>-̣+*`^') &&
			is_numeric($_POST['numCard']) && strlen($_POST['numCard'])== 16 &&
			is_numeric($_POST['codCard'])&& strlen($_POST['codCard'])== 3 &&
			$_POST['cardE'] < $_POST['cardV']){
			//Codigo de Seguridad que genera falla en servidor externo			
			if($_POST['codCard']== "111"){
				header("location:./buyFail.php");
			} else {
				//Datos de tarjeta para enviar al servidor externo
				$card=$_POST['card'];
				$tit=$_POST['titCard'];
				$num=$_POST['numCard'];
				$emision=$_POST['cardE'];
				$venc=$_POST['cardV'];
				$cod=$_POST['codCard'];
				//Datos para la bbdd
				$today= date('Y/m/d');
				$cantCred=$_POST['cantCredReq'];
				$idUs= $_SESSION['userId'];
				//Instancio nuevo objeto crédito
				$credit=new Credit();
				$credit->setOperationDate($today);
				$credit->setCantidad($cantCred);
				$credit->setUserId($idUs);
				//Inserción en bbdd
				$entityManager-> persist($credit);
				$entityManager-> flush();
				header("location:./buyComplete.php");
				
			}
		} else {
			//Uno o varios de los datos no pasaron las validaciones del servidor
			header("location:formCredits.php?message=camposIncorrectos");
			echo "Verific&aacute; los datos ingresados";
		}
} else {
	//Los campos no llegan completos desde el formulario
	//$_SESSION['error']= "Información enviada incompleta";
	header("location:formCredits.php?message=notComplete");
}
?>