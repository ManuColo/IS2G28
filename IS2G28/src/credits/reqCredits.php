<?php
session_start();
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
				$card=$_POST['card'];
				$tit=$_POST['titCard'];
				$num=$_POST['numCard'];
				$emision=$_POST['cardE'];
				$venc=$_POST['cardV'];
				$cod=$_POST['codCard'];
				$idUs= $_SESSION['userId'];
				$cantCred=$_POST['cantCredReq'];
				$credit=new Credit();
				$credit->setOperationDate('06/07');
				$credit->setCantidad($cantCred);
				$credit->setUserId($idUs);
				var_dump($credit);
				die();
				$entityManager-> persist($credit);
				$entityManager-> flush();
				header("location:./buyComplete.php");
				
			}
}?>