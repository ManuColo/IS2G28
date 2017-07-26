<?php

use Symfony\Component\Validator\Validation;

require_once __DIR__.'/../../config/doctrine_config.php';
require_once __DIR__.'/../common/lib.php';

session_start();

// Redirigir usuario no logueado a la pagina de login
if (!$_SESSION['logged']) {
  header("location:../login/login.php");
}

//var_dump($_FILES);

// Recuperar de la petición los datos editados del favor
$favorData = filter_input(INPUT_POST, 'favor', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
// Obtener el ID del favor a modificar
$favorId = filter_var($favorData['id'], FILTER_VALIDATE_INT, array(
    'options' => array('min_range' => 1)
));
// Obtener flag que indica si debe eliminarse o no la foto actual del favor
$deletedPhotoFlag = filter_input(INPUT_POST, 'favor_photo_deleted_flag', FILTER_VALIDATE_BOOLEAN);


// Comprobar que el ID del favor sea válido
if (!$favorId) {
  // Setear mensaje de error y redirigir al usuario al listado de favores  
  addMessage('danger', 'ID de favor inválido.');
  header("location:list.php");
  exit();
  //die('ID de favor inválido.');
}

// Buscar favor con el id dado como parámetro de la petición
$favor = $entityManager->getRepository('Favor')->find($favorId);

// Comprobar que exista el favor dado
if (!$favor) {
  // Setear mensaje de error y redirigir al usuario al listado de favores
  addMessage('danger', 'No existe el favor con el ID dado.');  
  header("location:list.php");
  exit();  
  //die('No existe el favor con el ID dado.');
}

// Obtener el usuario logueado en el sistema
$user = $entityManager->getRepository('User')->find($_SESSION['userId']);

// Comprobar que el favor sea propiedad del usuario 
if ($favor->getOwner() !== $user) {
  // Setear mensaje de error y redirigir al usuario a la vista del favor
  addMessage('danger', 'No puede editar un favor que no le pertenece.');        
  header("location:show.php?id=".$favor->getId());  
  exit();  
  //die('No puede editar un favor que no le pertenece.');
}

// Comprobar que el favor no tenga postulantes
if (count($favor->getMyPostulations()) > 0) {
  // Setear mensaje de error y redirigir al usuario a la vista del favor
  addMessage('danger', 'No puede editar un favor que tiene postulantes.');  
  header("location:show.php?id=".$favor->getId());
  exit();
  //die('No puede editar un favor que tiene postulantes.');
}

// Obtener los datos editados del favor en un formato limpio
$favorData = getRequestDataClean($favorData, $_FILES);
// Guardar en una variable auxiliar la foto actual del favor
$favorCurrentPhoto = $favor->getPhoto();

// Actualizar objeto favor con los datos actualizados procedentes de la petición
$favor = updateFavor($favor, $favorData);

// Validar datos del favor editado
$validator = Validation::createValidatorBuilder()
  ->addMethodMapping('loadValidatorMetadata')
  ->getValidator()
;
$violations = $validator->validate($favor);
$errors = array();
foreach ($violations as $violation) {
  $errors[$violation->getPropertyPath()] = $violation->getMessage();  
}

// Comprobar que no haya errores de validación. De ser así, persistir los cambios en la base de datos
if (count($violations) === 0) {
  
  $uploadedPhoto = $favor->getPhoto();
  
  // Comprobar si debe eliminarse la foto actual del favor
  $shouldDeletePhoto = $favorCurrentPhoto && ($uploadedPhoto || $deletedPhotoFlag);  
  if ($shouldDeletePhoto) {
    // Eliminar foto actual del favor del sistema de archivos
    unlink($cfg->uploadDir . $favorCurrentPhoto);   
  }
    
  // Comprobar si se actualizó la foto del favor
  if ($uploadedPhoto) {
    // Mover el archivo correspondiente a la foto del favor al directorio de uploads
    $photoFileName = time() . basename($_FILES['favor_photo']['name']);
    $targetFile = $cfg->uploadDir . $photoFileName;
    move_uploaded_file($favor->getPhoto(), $targetFile);    
    // Actualizar foto asociada al favor actualizado
    $favor->setPhoto($photoFileName);          
  } else if ($shouldDeletePhoto) {
    $favor->setPhoto(null);          
  } else {
    $favor->setPhoto($favorCurrentPhoto);          
  }
  
  // Persistir objeto Favor en la base de datos
  $entityManager->persist($favor);
  $entityManager->flush();
  // Redirigir al visitante al listado de favores
  header("location:show.php?id=" . $favor->getId());    
}

// Obtener categorias disponibles
// Las categorias se despliegan como opciones del campo categoría del formulario
$categories = $entityManager->getRepository('Category')->findAll();

// Incluir template que contiene el formulario de edición con los datos del favor actualizados
$favor->setPhoto($favorCurrentPhoto);
$favor->setDeadline($favorData['deadline']);
include 'form-edition.tpl.php';



// ===============================================================================
// Funciones privadas
// ===============================================================================

/**
 * Retorna los datos del favor enviados en la peticion en una version limpia.
 * Esto significa que se remueven los espacios en blanco y se convierten los
 * caracteres especiales en entidades HTML para evitar ataques CSRF y otras
 * problemas de seguridad.
 * 
 * @param array $requestData
 * @return array
 */
function getRequestDataClean($requestData, $requestFiles) 
{
  $favorData = array();
  $favorData['title'] = cleanInput($requestData['title']);
  $favorData['description'] = cleanInput($requestData['description']);
  $favorData['city'] = cleanInput($requestData['city']);
  $favorData['deadline'] = cleanInput($requestData['deadline']);  
  // Cargar path del archivo temporal, correspondiente a la foto, enviado en la peticion
  if (isset($requestFiles['favor_photo'])) {
    $favorData['photo'] = $requestFiles['favor_photo']['tmp_name'];  
  } else {
    $favorData['photo'] = null;
  }
  $favorData['category'] = cleanInput($requestData['category']);
  
  return $favorData;
}

/**
 * Retorna el objeto favor con sus datos actualizados.
 * 
 * @param Favor $favor
 * @param array $favorData
 * @return Favor
 */
function updateFavor(Favor $favor, $favorData)
{
   global $entityManager; // Permite acceso a la variable externa $entityManager desde la función
  
  $favor->setTitle($favorData['title']);
  $favor->setDescription($favorData['description']);
  $favor->setPhoto($favorData['photo']);
  $favor->setCity($favorData['city']);
  // Convertir fecha limite desde un string en formato "dd/mm/yyyy" a un objeto DateTime  
  $favor->setDeadline(new DateTime(parseStringDate($favorData['deadline'])));
  // Recuperar el objeto categoria y vincularlo al favor
  $category = $entityManager->getRepository('Category')->find($favorData['category']);
  $favor->setCategory($category);
  /*
  if ($category) {
    $favor->setCategory($category);
  }
  */
  
  return $favor;
}

/**
 * Convierte un string que representa una fecha en formato "dd/mm/yyyy" a una representacion
 * de la fecha en formato "yyyy-mm-dd"
 * 
 * @param string $strDate
 * @return string
 */
function parseStringDate($strDate)
{
  $result = '';
  // Obtener en un arreglo los componentes de la fecha (dia, mes, anio)
  $dateParts = explode('/', $strDate, 3);
  $countParts = count($dateParts);
  // Concater las partes de la fecha en sentido inverso
  for ($i=$countParts-1; $i >= 0; $i--) {
    $result = $result . $dateParts[$i];
    if ($i !== 0) {
      $result = $result . '-';
    }        
  }
  return $result;  
}