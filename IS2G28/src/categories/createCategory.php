<?php
session_start();
require '../../config/doctrine_config.php';
require '../common/lib.php';

//Limpio los valores recibidos
$params = array_map("cleanInput",$_POST);
//Verifico la llegada de los datos completos
if (isset($params['category'])&& ($params['category']!=null)) {
	//Verifico si el mail existe en la base de datos
	$compare = $entityManager->getRepository('Category')->findBy(array('name'=>$_POST['category']));
		if($compare == null){
			//Asigno los valores recibidos a variables
			$cat=$params['category'];	 
			//Instancio un nuevo objeto con los datos recibidos
			$category=new Category() ;
			$category->setName ($cat);
			//Inserción en bbdd
			$entityManager-> persist($category);
			$entityManager-> flush();
			//Se informa la creación y se redirige al login
			header("location:../categories/list.php?message=categoryCreated");
			} 
			else {
				//La categoría que quiero ingresar ya existe
				addMessage('danger','El nombre ingresado ya est&aacute; asignado a una categor&iacute;a');
				include 'newCategory.php';
			} 			
} else {
	//Los campos no llegan completos desde el formulario
	addMessage('danger','Debe ingresar un nombre para la categor&iacute;a');
	include 'newCategory.php';
}
?>