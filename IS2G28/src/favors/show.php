<?php

// Recuperar sesion del usuario
session_start();
if ($_SESSION['logged']) {
  require '../../config/doctrine_config.php';
  // Recuperar de la peticion el ID del favor a visualizar
  $favorId = cleanInput($_GET['id']);  
  // Buscar via Doctrine el favor a visualizar
  $favor = $entityManager->getRepository('Favor')->find($favorId);
  // Incluir template que visualiza un favor
  include 'show.tpl.php';  
} else {
  header("location:../login/login.php");
}

function cleanInput($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}