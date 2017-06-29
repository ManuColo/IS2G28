<?php
require '../common/lib.php';
// Recuperar sesion del usuario
session_start();
if ($_SESSION['logged']) {
  require '../../config/doctrine_config.php';
  // Recuperar de la peticion el ID del favor a visualizar
  $favorId = cleanInput($_GET['id']);  
  // Buscar via Doctrine el favor a visualizar
  $favor = $entityManager->getRepository('Favor')->find($favorId);
  // Buscar via Doctrine el usuario logueado en la aplicación
  $user = $entityManager->getRepository('User')->find($_SESSION['userId']);
  
  // Incluir template que visualiza un favor
  include 'show.tpl.php';  
} else {
  header("location:../login/login.php");
}