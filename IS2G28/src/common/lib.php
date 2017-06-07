<?php

// Función para limpiar los parámetros

function cleanInput($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

/* Función para enviar un mensaje al usuario
 * Recibe un tipo que debería ser "success", "info", "warning" o "danger"
 * y un mensaje que debería estar listo para mostrar.
 * El mensaje se guardará en la sesión y se mostrará en la página siguiente 
 * o en la misma si se recarga
 */


function addMessage($type='info',$message){
	$_SESSION['message']= array($type,$message);
}

// Función para mostrar los mensajes

function showMessage(){
	if (isset($_SESSION['message'])) {
		$message = $_SESSION['message'];
		unset($_SESSION['message']);?>
		<div class="messenger alert alert-<?php echo $message[0];?>">
			<?php echo $message[1];?>
		</div>
		<script type="text/javascript">
			$(".messenger").delay(3000).fadeOut('slow');
		</script>
	<?php }
}