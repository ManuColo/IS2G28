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
// Crear un objeto favor con los datos actualizados
$updatedFavor = createFavor($favorData);

// Validar datos del favor editado
$validator = Validation::createValidatorBuilder()
  ->addMethodMapping('loadValidatorMetadata')
  ->getValidator()
;
$violations = $validator->validate($updatedFavor);
$errors = array();
foreach ($violations as $violation) {
  $errors[$violation->getPropertyPath()] = $violation->getMessage();  
}

/*
// Imprimir errores de validacion
if (count($violations) > 0) {
  $errorsString = (string) $violations;
  echo $errorsString;
}
*/

// Comprobar que no haya errores de validación. De ser así, persistir los cambios en la base de datos
if (count($violations) === 0) {
  // Actualizar datos del favor
  $favor->setTitle($updatedFavor->getTitle());
  $favor->setDescription($updatedFavor->getDescription());
  $favor->setCity($updatedFavor->getCity());
  $favor->setDeadline(new DateTime($updatedFavor->getDeadline()));
  
  // Comprobar si debe eliminarse la foto actual del favor
  $shouldDeletePhoto = $favor->getPhoto() && ($updatedFavor->getPhoto() || $deletedPhotoFlag);  
  if ($shouldDeletePhoto) {
    // Eliminar foto actual del favor del sistema de archivos
    unlink($cfg->uploadDir . $favor->getPhoto());
    // Actualizar propiedad del favor
    $favor->setPhoto(null);    
  }
   
  // Comprobar si se actualizó la foto del favor
  if ($updatedFavor->getPhoto()) {
    // Mover el archivo correspondiente a la foto del favor al directorio de uploads
    $photoFileName = time() . basename($_FILES['favor_photo']['name']);
    $targetFile = $cfg->uploadDir . $photoFileName;
    move_uploaded_file($updatedFavor->getPhoto(), $targetFile);    
    // Actualizar foto asociada al favor actualizado
    $updatedFavor->setPhoto($photoFileName);      
    $favor->setPhoto($updatedFavor->getPhoto());    
  }        
  
  // Persistir objeto Favor en la base de datos
  $entityManager->persist($favor);
  $entityManager->flush();
  // Redirigir al visitante al listado de favores
  header("location:show.php?id=" . $favor->getId());    
}


// Incluir template que contiene el formulario de edición con los datos del favor actualizados
$favorPhoto = $favor->getPhoto();
$favor = $updatedFavor;
$favor->setPhoto($favorPhoto);
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
  return $favorData;
}

/**
 * Retorna un nuevo objeto Favor que se inicializa con los datos limpios del favor
 * obtenidos desde la peticion.
 * 
 * @param array $favorData
 * @return \Favor
 */
function createFavor($favorData) 
{
  $favor = new Favor();
  $favor->setTitle($favorData['title']);
  $favor->setDescription($favorData['description']);
  $favor->setPhoto($favorData['photo']);
  $favor->setCity($favorData['city']);
  // Convertir fecha limite desde un string en formato "dd/mm/yyyy" a un objeto DateTime  
  $favor->setDeadline(parseStringDate($favorData['deadline']));
  
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