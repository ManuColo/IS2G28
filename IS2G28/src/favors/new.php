<?php

session_start();
if ($_SESSION['logged']) {

  require_once __DIR__.'/../../config/doctrine_config.php';
  
  $favor = new Favor();
  $favor->setDeadline('');
  $errors = array();
  
  // Obtener categorias disponibles
  // Las categorias se despliegan como opciones del campo categoría del formulario
  $categories = $entityManager->getRepository('Category')->findAll();
  
  include 'form.tpl.php';
} else {
	header("location:../login/login.php");
}
