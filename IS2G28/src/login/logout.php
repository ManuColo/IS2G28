<?php
session_start();
if ($_SESSION['logged']) {
	unset($_SESSION['logged']);
	unset($_SESSION['loginTime']);
	unset($_SESSION['userId']);
	session_destroy();
	header("location:../");
} else {
	header("location:../login/login.php");
	exit();
}
?>