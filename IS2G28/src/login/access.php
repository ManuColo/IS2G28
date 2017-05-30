<?php
if (isset($_POST)&&($_POST['user']!=null)&&($_POST['password']!=null)) {
	if (!filter_var($_POST['user'], FILTER_VALIDATE_EMAIL)=== false) {
		echo "hola";
	} else {
		header("location:login.php?message=loginFail");
	}
}