<?php

require_once __DIR__.'/../../config/doctrine_config.php';
require_once __DIR__.'/../common/lib.php';

session_start();

// Redirigir usuario no logueados a la pagina de login
if (!$_SESSION['logged']) {
  header("location:../login/login.php");
}

// Recuperar el ID del favor a modificar
$favorId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, array(
    'options' => array('min_range' => 1)
));

// Comprobar que el ID del favor sea válido
if (!$favorId) {
  die('ID de favor inválido.');
}

// Buscar favor con el id dado como parámetro de la petición
$favor = $entityManager->getRepository('Favor')->find($favorId);

// Comprobar que exista el favor dado
if (!$favor) {
  die('No existe el favor con el ID dado.');
}

// Obtener el usuario logueado en el sistema
$user = $entityManager->getRepository('User')->find($_SESSION['userId']);

// Comprobar que el favor sea propiedad del usuario 
if ($favor->getOwner() !== $user) {
  die('No puede editar un favor que no le pertenece.');
}

// Comprobar que el favor no tenga postulantes
if (count($favor->getMyPostulations()) > 0) {
  die('No puede editar un favor que tiene postulantes.');
}

// Incluir formulario de edición de un favor
include 'form-edition.tpl.php';
