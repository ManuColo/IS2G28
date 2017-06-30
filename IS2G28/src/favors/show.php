<?php
require '../common/lib.php';
require '../../config/doctrine_config.php';

// Recuperar sesion del usuario
session_start();
// Redirigir usuario no logueado a la pagina de login
if (!$_SESSION['logged']) {
  header("location:../login/login.php");
}

// Recuperar de la peticion el ID del favor a visualizar
$favorId = cleanInput($_GET['id']);  

// Buscar via Doctrine el favor a visualizar
$favor = $entityManager->getRepository('Favor')->find($favorId);

// Buscar el usuario logueado en la aplicación
$user = $entityManager->getRepository('User')->find($_SESSION['userId']);

// Incluir template que visualiza un favor
include 'show.tpl.php';
