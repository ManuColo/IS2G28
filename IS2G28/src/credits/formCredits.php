<?php 
session_start();
if ($_SESSION['logged']) { 
	include 'formCredit.tpl.php';
} else {
	header("location:../login/login.php");
	exit();
}
?>