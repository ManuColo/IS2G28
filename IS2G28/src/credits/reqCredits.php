<?php
require '../../config/doctrine_config.php';
if (isset($_POST['card'])&&
		($_POST['titCard'])&&
		($_POST['numCard'])&&
		($_POST['cardE'])&&
		($_POST['cardV'])&&
		($_POST['codCard'])&&
		($_POST['cantCredReq'])&&
		($_POST['card']!=null)&&
		($_POST['titCard']!=null)&&
		($_POST['numCard']!=null)&&
		($_POST['cardE']!=null)&&
		($_POST['cardV']!=null)&&
		($_POST['codCard']!=null)&&
		($_POST['cantCredReq']!=null)
		){
			if($_POST['codCard']== "111"){
				header("location:./buyFail.php");
			} else {
				//Datos para enviar al servidor externo
				//$card=$_POST['card'];
				//$tit=$_POST['titCard'];
				//$num=$_POST['numCard'];
				//$emision=$_POST['cardE'];
				//$venc=$_POST['cardV'];
				//$cod=$_POST['codCard'];
				$cantCred=$_POST['cantCredReq'];
				$cred=new Credit();
				$cred->setOperationDate(new \DateTime());
				$cred->setCantidad($cantCred);
				$cred->setUserId('11');
				$entityManager-> persist($cred);
				$entityManager-> flush();
				header("location:./buyComplete.php");
				
			}
}?>
