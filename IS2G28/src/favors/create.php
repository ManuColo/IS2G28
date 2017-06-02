<?php
use Symfony\Component\Validator\Validation;

session_start();
if ($_SESSION['logged']) {
  require_once __DIR__.'/../../config/doctrine_config.php';  

  // Recuperar datos de la peticion
  $favorData = getRequestDataClean($_POST['favor'], $_FILES);
  $favor = createFavor($favorData);

  // Validar datos del nuevo favor
  $validator = Validation::createValidatorBuilder()
    ->addMethodMapping('loadValidatorMetadata')
    ->getValidator()
  ;
  $violations = $validator->validate($favor);
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



  // Comprobar que no hay errores de validacion 
  if (count($violations) === 0) {
    // Comprobar que se haya subido una foto asociada al favor
    if ($favor->getPhoto()) {
      // Mover el archivo correspondiente a la foto del favor al directorio de uploads
      $photoFileName = time() . basename($_FILES['favor_photo']['name']);
      $targetFile = $cfg->uploadDir . $photoFileName;
      move_uploaded_file($favor->getPhoto(), $targetFile);    
      // Actualizar el objeto que modela el favor
      $favor->setPhoto($photoFileName);    
    }
     $favor->setDeadline(new DateTime($favor->getDeadline()));       
    // Persistir objeto Favor en la base de datos
    $entityManager->persist($favor);
    $entityManager->flush();

    // Redirigir al visitante al listado de favores
    header("location:list.php");  
  }

  // Poner la fecha en el formato de visualizacion original "dd/mm/yyyy"
  $favor->setDeadline($favorData['deadline']);
  // Mostar formulario con errores de validacion
  include 'form.tpl.php';
} else {
  header("location:../login/login.php");
}




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
  $favorData['photo'] = $requestFiles['favor_photo']['tmp_name'];  
  
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

function cleanInput($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
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