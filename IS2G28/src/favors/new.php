<?php

session_start();
if ($_SESSION['logged']) {

  require_once __DIR__.'/../../config/doctrine_config.php';
  
  $favor = new Favor();
  $favor->setDeadline('');
  $errors = array();
  
  include 'form.tpl.php';
} else {
	header("location:../login/login.php");
}
