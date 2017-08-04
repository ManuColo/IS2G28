<?php

session_start();
if ($_SESSION['logged']) {

  require_once __DIR__.'/../../config/doctrine_config.php';
  require_once __DIR__.'/../common/lib.php';
  
   // Obtener el usuario logueado en el sistema
  $user = $entityManager->getRepository('User')->find($_SESSION['userId']);
  
  // Comprobar que el usuario no tenga calificaciones pendientes
  if ($user->hasPendingQualifications()) {
    addMessage('danger', 'No puede publicar una nueva gauchada porque tiene calificaciones pendientes.');
    header('location:list.php');
    exit();
  }
  
 
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
