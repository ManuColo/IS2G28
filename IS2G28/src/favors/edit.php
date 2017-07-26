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
  // Setear mensaje de error y redirigir al usuario al listado de favores  
  addMessage('danger', 'ID de favor inválido.');
  header("location:list.php");
  exit();
}

// Buscar favor con el id dado como parámetro de la petición
$favor = $entityManager->getRepository('Favor')->find($favorId);

// Comprobar que exista el favor dado
if (!$favor) {
  // Setear mensaje de error y redirigir al usuario al listado de favores
  addMessage('danger', 'No existe el favor con el ID dado.');  
  header("location:list.php");
  exit();  
}

// Obtener el usuario logueado en el sistema
$user = $entityManager->getRepository('User')->find($_SESSION['userId']);

// Comprobar que el favor sea propiedad del usuario 
if ($favor->getOwner() !== $user) {
  // Setear mensaje de error y redirigir al usuario a la vista del favor
  addMessage('danger', 'No puede editar un favor que no le pertenece.');        
  header("location:show.php?id=".$favor->getId());  
  exit();  
}

// Comprobar que el favor no tenga postulantes
if (count($favor->getMyPostulations()) > 0) {
  // Setear mensaje de error y redirigir al usuario a la vista del favor
  addMessage('danger', 'No puede editar un favor que tiene postulantes.');  
  header("location:show.php?id=".$favor->getId());
  exit();  
}

// Obtener categorias disponibles
// Las categorias se despliegan como opciones del campo categoría del formulario
$categories = $entityManager->getRepository('Category')->findAll();

// Incluir formulario de edición de un favor
include 'form-edition.tpl.php';
